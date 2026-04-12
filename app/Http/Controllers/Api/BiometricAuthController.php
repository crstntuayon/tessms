<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialRpEntity;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\PublicKeyCredentialParameters;
use Webauthn\PublicKeyCredentialDescriptor;
use Cose\Algorithms;

class BiometricAuthController extends Controller
{
    /**
     * Check if biometric authentication is available
     */
    public function checkAvailability()
    {
        return response()->json([
            'available' => true,
            'supports_biometric' => true,
            'message' => 'Biometric authentication is supported'
        ]);
    }

    /**
     * Get registration options for WebAuthn
     */
    public function getRegistrationOptions(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Generate challenge
        $challenge = random_bytes(32);
        
        // Store challenge in session
        session(['webauthn_challenge' => base64_encode($challenge)]);

        // Create RP entity (Relying Party - your app)
        $rp = [
            'name' => config('app.name', 'TESSMS'),
            'id' => $request->getHost()
        ];

        // Create user entity
        $userEntity = [
            'id' => base64_encode($user->id),
            'name' => $user->email ?? $user->username,
            'displayName' => $user->first_name . ' ' . $user->last_name
        ];

        // Generate options
        $options = [
            'rp' => $rp,
            'user' => $userEntity,
            'challenge' => base64_encode($challenge),
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7],   // ES256
                ['type' => 'public-key', 'alg' => -257] // RS256
            ],
            'authenticatorSelection' => [
                'authenticatorAttachment' => 'platform', // Use device biometrics
                'userVerification' => 'required',
                'residentKey' => 'preferred'
            ],
            'attestation' => 'none',
            'timeout' => 60000
        ];

        return response()->json($options);
    }

    /**
     * Register biometric credential
     */
    public function register(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'rawId' => 'required|string',
            'type' => 'required|string',
            'response.clientDataJSON' => 'required|string',
            'response.attestationObject' => 'required|string'
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            // Store the credential
            DB::table('biometric_credentials')->updateOrInsert(
                ['user_id' => $user->id, 'credential_id' => $request->id],
                [
                    'raw_id' => $request->rawId,
                    'type' => $request->type,
                    'public_key' => json_encode($request->response),
                    'device_name' => $request->device_name ?? 'Unknown Device',
                    'last_used_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Biometric authentication registered successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authentication options
     */
    public function getAuthenticationOptions(Request $request)
    {
        // Generate challenge
        $challenge = random_bytes(32);
        session(['webauthn_auth_challenge' => base64_encode($challenge)]);

        $options = [
            'challenge' => base64_encode($challenge),
            'timeout' => 60000,
            'rpId' => $request->getHost(),
            'allowCredentials' => [],
            'userVerification' => 'required'
        ];

        return response()->json($options);
    }

    /**
     * Authenticate with biometric
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'rawId' => 'required|string',
            'response.authenticatorData' => 'required|string',
            'response.clientDataJSON' => 'required|string',
            'response.signature' => 'required|string',
            'userHandle' => 'nullable|string'
        ]);

        try {
            // Find credential
            $credential = DB::table('biometric_credentials')
                ->where('credential_id', $request->id)
                ->first();

            if (!$credential) {
                return response()->json([
                    'success' => false,
                    'error' => 'Credential not found'
                ], 404);
            }

            // Get user
            $user = User::find($credential->user_id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not found'
                ], 404);
            }

            // Update last used
            DB::table('biometric_credentials')
                ->where('id', $credential->id)
                ->update(['last_used_at' => now()]);

            // Log in the user
            Auth::login($user);

            // Create session
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Authentication successful',
                'redirect' => $this->getDashboardRoute($user),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'role' => $user->role?->name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Authentication failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get registered biometric credentials for user
     */
    public function getCredentials()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $credentials = DB::table('biometric_credentials')
            ->where('user_id', $user->id)
            ->select('id', 'device_name', 'last_used_at', 'created_at')
            ->get()
            ->map(function ($cred) {
                return [
                    'id' => $cred->id,
                    'device_name' => $cred->device_name,
                    'last_used' => $cred->last_used_at ? \Carbon\Carbon::parse($cred->last_used_at)->diffForHumans() : 'Never',
                    'created' => \Carbon\Carbon::parse($cred->created_at)->format('M d, Y')
                ];
            });

        return response()->json([
            'success' => true,
            'credentials' => $credentials
        ]);
    }

    /**
     * Remove biometric credential
     */
    public function removeCredential($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $deleted = DB::table('biometric_credentials')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Biometric credential removed'
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Credential not found'
        ], 404);
    }

    /**
     * Get dashboard route based on user role
     */
    private function getDashboardRoute(User $user)
    {
        $role = strtolower($user->role?->name ?? '');
        
        return match($role) {
            'admin', 'system admin' => '/admin/dashboard',
            'teacher' => '/teacher/dashboard',
            'student' => '/student/dashboard',
            'registrar' => '/registrar/dashboard',
            default => '/dashboard'
        };
    }
}
