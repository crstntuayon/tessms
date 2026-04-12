/**
 * TESSMS Biometric Authentication Module
 * Uses Web Authentication API (WebAuthn) for Face ID / Fingerprint login
 */

class BiometricAuth {
    constructor() {
        this.isAvailable = false;
        this.checkAvailability();
    }

    /**
     * Check if biometric authentication is available on this device
     */
    async checkAvailability() {
        if (!window.PublicKeyCredential) {
            console.log('[Biometric] WebAuthn not supported');
            this.isAvailable = false;
            return false;
        }

        try {
            this.isAvailable = await PublicKeyCredential.isUserVerifyingPlatformAuthenticatorAvailable();
            console.log('[Biometric] Available:', this.isAvailable);
            return this.isAvailable;
        } catch (error) {
            console.error('[Biometric] Error checking availability:', error);
            this.isAvailable = false;
            return false;
        }
    }

    /**
     * Check if user has biometric credentials registered
     */
    async hasCredentials() {
        try {
            const response = await fetch('/api/biometric/credentials', {
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                return data.credentials && data.credentials.length > 0;
            }
            return false;
        } catch (error) {
            console.error('[Biometric] Error checking credentials:', error);
            return false;
        }
    }

    /**
     * Register biometric authentication for current user
     */
    async register(deviceName = null) {
        if (!this.isAvailable) {
            throw new Error('Biometric authentication is not available on this device');
        }

        try {
            // Get registration options from server
            const optionsResponse = await fetch('/api/biometric/register-options', {
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (!optionsResponse.ok) {
                throw new Error('Failed to get registration options');
            }

            const options = await optionsResponse.json();

            // Prepare options for WebAuthn
            const publicKeyCredentialCreationOptions = {
                rp: options.rp,
                user: {
                    id: this.base64UrlToBuffer(options.user.id),
                    name: options.user.name,
                    displayName: options.user.displayName
                },
                challenge: this.base64UrlToBuffer(options.challenge),
                pubKeyCredParams: options.pubKeyCredParams,
                authenticatorSelection: options.authenticatorSelection,
                attestation: options.attestation,
                timeout: options.timeout
            };

            // Create credential
            const credential = await navigator.credentials.create({
                publicKey: publicKeyCredentialCreationOptions
            });

            if (!credential) {
                throw new Error('Credential creation was cancelled');
            }

            // Send credential to server
            const registrationData = {
                id: credential.id,
                rawId: this.bufferToBase64Url(credential.rawId),
                type: credential.type,
                response: {
                    clientDataJSON: this.bufferToBase64Url(credential.response.clientDataJSON),
                    attestationObject: this.bufferToBase64Url(credential.response.attestationObject)
                },
                device_name: deviceName || this.getDeviceName()
            };

            const registerResponse = await fetch('/api/biometric/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(registrationData)
            });

            const result = await registerResponse.json();

            if (result.success) {
                return { success: true, message: 'Biometric authentication registered successfully' };
            } else {
                throw new Error(result.error || 'Registration failed');
            }

        } catch (error) {
            console.error('[Biometric] Registration error:', error);
            
            if (error.name === 'NotAllowedError') {
                throw new Error('Biometric registration was cancelled or not allowed');
            } else if (error.name === 'SecurityError') {
                throw new Error('Biometric authentication is not supported in this context');
            }
            
            throw error;
        }
    }

    /**
     * Authenticate using biometric
     */
    async authenticate() {
        if (!this.isAvailable) {
            throw new Error('Biometric authentication is not available on this device');
        }

        try {
            // Get authentication options from server
            const optionsResponse = await fetch('/api/biometric/auth-options', {
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (!optionsResponse.ok) {
                throw new Error('Failed to get authentication options');
            }

            const options = await optionsResponse.json();

            // Prepare options for WebAuthn
            const publicKeyCredentialRequestOptions = {
                challenge: this.base64UrlToBuffer(options.challenge),
                timeout: options.timeout,
                rpId: options.rpId,
                allowCredentials: options.allowCredentials.map(cred => ({
                    ...cred,
                    id: cred.id ? this.base64UrlToBuffer(cred.id) : undefined
                })),
                userVerification: options.userVerification
            };

            // Get credential
            const assertion = await navigator.credentials.get({
                publicKey: publicKeyCredentialRequestOptions
            });

            if (!assertion) {
                throw new Error('Authentication was cancelled');
            }

            // Send assertion to server
            const authData = {
                id: assertion.id,
                rawId: this.bufferToBase64Url(assertion.rawId),
                type: assertion.type,
                response: {
                    authenticatorData: this.bufferToBase64Url(assertion.response.authenticatorData),
                    clientDataJSON: this.bufferToBase64Url(assertion.response.clientDataJSON),
                    signature: this.bufferToBase64Url(assertion.response.signature),
                    userHandle: assertion.response.userHandle ? 
                        this.bufferToBase64Url(assertion.response.userHandle) : null
                }
            };

            const authResponse = await fetch('/api/biometric/authenticate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(authData)
            });

            const result = await authResponse.json();

            if (result.success) {
                return { 
                    success: true, 
                    message: 'Authentication successful',
                    redirect: result.redirect,
                    user: result.user
                };
            } else {
                throw new Error(result.error || 'Authentication failed');
            }

        } catch (error) {
            console.error('[Biometric] Authentication error:', error);
            
            if (error.name === 'NotAllowedError') {
                throw new Error('Biometric authentication was cancelled or not recognized');
            } else if (error.name === 'SecurityError') {
                throw new Error('Biometric authentication is not supported in this context');
            }
            
            throw error;
        }
    }

    /**
     * Get registered credentials
     */
    async getCredentials() {
        try {
            const response = await fetch('/api/biometric/credentials', {
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                return data.credentials || [];
            }
            return [];
        } catch (error) {
            console.error('[Biometric] Error getting credentials:', error);
            return [];
        }
    }

    /**
     * Remove a biometric credential
     */
    async removeCredential(credentialId) {
        try {
            const response = await fetch(`/api/biometric/credentials/${credentialId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                return { success: true };
            } else {
                const data = await response.json();
                throw new Error(data.error || 'Failed to remove credential');
            }
        } catch (error) {
            console.error('[Biometric] Error removing credential:', error);
            throw error;
        }
    }

    /**
     * Helper: Convert base64url to ArrayBuffer
     */
    base64UrlToBuffer(base64url) {
        const base64 = base64url.replace(/-/g, '+').replace(/_/g, '/');
        const binary = atob(base64);
        const buffer = new ArrayBuffer(binary.length);
        const view = new Uint8Array(buffer);
        for (let i = 0; i < binary.length; i++) {
            view[i] = binary.charCodeAt(i);
        }
        return buffer;
    }

    /**
     * Helper: Convert ArrayBuffer to base64url
     */
    bufferToBase64Url(buffer) {
        const binary = String.fromCharCode(...new Uint8Array(buffer));
        const base64 = btoa(binary);
        return base64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
    }

    /**
     * Helper: Get CSRF token
     */
    getCsrfToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.content : '';
    }

    /**
     * Helper: Get device name
     */
    getDeviceName() {
        const userAgent = navigator.userAgent;
        if (userAgent.match(/iPhone|iPad|iPod/i)) {
            return 'iPhone/iPad';
        } else if (userAgent.match(/Android/i)) {
            return 'Android Device';
        } else if (userAgent.match(/Windows/i)) {
            return 'Windows Device';
        } else if (userAgent.match(/Mac/i)) {
            return 'Mac Device';
        }
        return 'Unknown Device';
    }
}

// Create global instance
window.biometricAuth = new BiometricAuth();

// Helper functions for global access
window.registerBiometric = async function(deviceName) {
    return await window.biometricAuth.register(deviceName);
};

window.authenticateWithBiometric = async function() {
    return await window.biometricAuth.authenticate();
};

window.isBiometricAvailable = async function() {
    return await window.biometricAuth.checkAvailability();
};

window.hasBiometricCredentials = async function() {
    return await window.biometricAuth.hasCredentials();
};
