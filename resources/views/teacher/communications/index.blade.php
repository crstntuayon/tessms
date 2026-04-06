<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Messages - Teacher Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        
        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        
        .message-item:hover { background: #f8fafc; }
        .message-item.unread { background: #eff6ff; }
        .message-item.unread:hover { background: #dbeafe; }
    </style>
</head>
<body class="min-h-screen bg-slate-50 font-sans antialiased"
      x-data="{ sidebarCollapsed: false, mobileOpen: false, showCompose: false }"
      x-init="if (window.innerWidth >= 1024) { sidebarCollapsed = false; }">

    <!-- Mobile Overlay -->
    <div x-show="mobileOpen" x-transition.opacity.duration.200ms @click="mobileOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden" style="display: none;"></div>

    <!-- Mobile Toggle Button -->
    <button @click="mobileOpen = !mobileOpen" 
            class="fixed top-4 left-4 z-50 lg:hidden w-12 h-12 bg-white rounded-2xl shadow-lg flex items-center justify-center text-slate-600 hover:text-indigo-600 transition-all border border-slate-100">
        <i class="fas fa-bars text-lg" x-show="!mobileOpen"></i>
        <i class="fas fa-times text-lg" x-show="mobileOpen"></i>
    </button>

    @include('teacher.includes.sidebar')

    <!-- Main Content -->
    <main class="min-h-screen flex flex-col lg:ml-72">
        
        <div class="flex h-screen overflow-hidden">
            <!-- Conversation List Sidebar -->
            <div class="w-full lg:w-80 bg-white border-r border-slate-200 flex flex-col">
                <!-- Header -->
                <div class="p-4 border-b border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h1 class="text-xl font-bold text-slate-800">Messages</h1>
                        <button @click="showCompose = true" 
                                class="lg:hidden p-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    
                    <!-- Search -->
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <form action="{{ route('teacher.communications.index') }}" method="GET">
                            <input type="hidden" name="tab" value="{{ $tab }}">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Search messages..." 
                                   class="w-full pl-9 pr-4 py-2 bg-slate-100 border-0 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                        </form>
                    </div>
                    
                    <!-- New Message Button (Desktop) -->
                    <button @click="showCompose = true" 
                            class="hidden lg:flex items-center justify-center gap-2 w-full mt-3 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-plus text-xs"></i>
                        New Message
                    </button>
                </div>
                
                <!-- Tabs -->
                <div class="flex border-b border-slate-200">
                    <a href="{{ route('teacher.communications.index', ['tab' => 'inbox']) }}" 
                       class="flex-1 py-3 text-center text-sm font-medium {{ $tab === 'inbox' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Inbox
                        @if($unreadCount > 0)
                            <span class="ml-1 bg-rose-500 text-white text-[10px] px-1.5 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('teacher.communications.index', ['tab' => 'sent']) }}" 
                       class="flex-1 py-3 text-center text-sm font-medium {{ $tab === 'sent' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">
                        Sent
                    </a>
                </div>

                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto scrollbar-thin">
                    @if($messages->count() > 0)
                        @foreach($messages as $message)
                            @php
                                $isSender = $message->sender_id === auth()->id();
                                $isUnread = !$isSender && !$message->is_read;
                                $otherPerson = $isSender ? $message->recipient : $message->sender;
                            @endphp
                            <a href="{{ route('teacher.communications.show', $message) }}" 
                               class="message-item flex items-center gap-3 p-4 border-b border-slate-100 {{ $isUnread ? 'unread' : '' }}">
                                
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full {{ $isSender ? 'bg-emerald-500' : 'bg-indigo-500' }} flex items-center justify-center text-white font-semibold text-sm">
                                        {{ $otherPerson ? strtoupper(substr($otherPerson->first_name ?? 'U', 0, 1)) : '?' }}
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline mb-0.5">
                                        <h3 class="font-semibold text-sm {{ $isUnread ? 'text-slate-900' : 'text-slate-700' }} truncate">
                                            {{ $otherPerson->full_name ?? 'Unknown' }}
                                            @if($isSender)
                                                <span class="text-xs text-emerald-600 font-normal ml-1">(You sent)</span>
                                            @endif
                                        </h3>
                                        <span class="text-xs text-slate-400 whitespace-nowrap">{{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm {{ $isUnread ? 'font-medium text-slate-800' : 'text-slate-600' }} truncate">{{ $message->subject }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ Str::limit($message->body, 50) }}</p>
                                    
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($message->attachments->count() > 0)
                                            <i class="fas fa-paperclip text-slate-400 text-xs"></i>
                                        @endif
                                        @if($message->reply_count > 0)
                                            <span class="text-[10px] bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded-full">{{ $message->reply_count }} replies</span>
                                        @endif
                                        @if($message->is_bulk)
                                            <span class="text-[10px] bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded-full">Bulk</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($isUnread)
                                    <div class="w-2 h-2 bg-indigo-500 rounded-full flex-shrink-0"></div>
                                @endif
                            </a>
                        @endforeach
                        
                        <div class="p-4 border-t border-slate-100">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-64 text-center p-4">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-inbox text-2xl text-slate-400"></i>
                            </div>
                            <p class="text-slate-600 font-medium">No messages yet</p>
                            <p class="text-sm text-slate-400 mt-1">Start a conversation with your students</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Empty State / Compose Modal -->
            <div class="hidden lg:flex flex-1 items-center justify-center bg-slate-50">
                <div class="text-center">
                    <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-3xl text-indigo-500"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-800 mb-2">Select a conversation</h2>
                    <p class="text-slate-500">Choose a message from the list to view the full conversation</p>
                    <button @click="showCompose = true" 
                            class="mt-6 px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-all">
                        <i class="fas fa-plus mr-2"></i>New Message
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Compose Modal -->
    <div x-show="showCompose" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         @click.self="showCompose = false">
        
        <div x-show="showCompose"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-hidden flex flex-col">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">New Message</h3>
                <button @click="showCompose = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-4">
                @if($sections->count() === 0)
                    <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl mb-4">
                        <i class="fas fa-info-circle text-amber-600 mr-2"></i>
                        No sections assigned. Please contact administrator.
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('teacher.communications.store') }}" method="POST" enctype="multipart/form-data" id="composeForm">
                    @csrf
                    
                    <!-- Recipient Type -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Send To</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="recipient_type" value="individual" checked 
                                       class="w-4 h-4 text-indigo-600 focus:ring-indigo-500"
                                       onchange="toggleRecipientType('individual')">
                                <span class="text-sm text-slate-700">Individual Student</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="recipient_type" value="section" 
                                       class="w-4 h-4 text-indigo-600 focus:ring-indigo-500"
                                       onchange="toggleRecipientType('section')">
                                <span class="text-sm text-slate-700">Entire Section</span>
                            </label>
                        </div>
                    </div>

                    <!-- Section Selection -->
                    <div class="mb-4" id="sectionSelectDiv">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Section <span class="text-rose-500">*</span></label>
                        <select name="section_id" id="sectionSelect" required
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-sm"
                                onchange="loadStudents(this.value)">
                            <option value="">Choose a section...</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->gradeLevel->name ?? 'N/A' }} - {{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Individual Student Selection -->
                    <div class="mb-4" id="individualSelectDiv">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Student <span class="text-rose-500">*</span></label>
                        <select name="recipient_id" id="studentSelect" required
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-sm">
                            <option value="">First select a section...</option>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Subject <span class="text-rose-500">*</span></label>
                        <input type="text" name="subject" required 
                               class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                               placeholder="Enter message subject...">
                    </div>

                    <!-- Message Body -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Message <span class="text-rose-500">*</span></label>
                        <textarea name="body" required rows="4"
                                  class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none text-sm"
                                  placeholder="Type your message here..."></textarea>
                    </div>

                    <!-- Attachments -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Attachments</label>
                        <label class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-indigo-400 transition-colors">
                            <input type="file" name="attachments[]" multiple class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx,.txt">
                            <div class="text-center">
                                <i class="fas fa-cloud-upload-alt text-xl text-slate-400 mb-1"></i>
                                <p class="text-xs text-slate-600">Click to upload files</p>
                                <p class="text-[10px] text-slate-400">Max 10MB per file</p>
                            </div>
                        </label>
                        <div id="filePreview" class="mt-2 flex flex-wrap gap-2"></div>
                    </div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t border-slate-200 bg-slate-50">
                <button type="button" @click="showCompose = false" 
                        class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg text-sm font-medium transition-all">
                    Cancel
                </button>
                <button type="submit" form="composeForm" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i>
                    <span id="sendBtnText">Send Message</span>
                </button>
            </div>
        </div>
    </div>

<script>
// Toggle recipient type
function toggleRecipientType(type) {
    const individualDiv = document.getElementById('individualSelectDiv');
    const studentSelect = document.getElementById('studentSelect');
    const sectionSelect = document.getElementById('sectionSelect');
    const sendBtnText = document.getElementById('sendBtnText');
    
    if (type === 'section') {
        individualDiv.style.display = 'none';
        studentSelect.removeAttribute('required');
        studentSelect.value = '';
        sendBtnText.textContent = 'Send to Section';
        if (studentSelect.querySelector('option')) {
            studentSelect.innerHTML = '<option value="">Sending to entire section</option>';
        }
    } else {
        individualDiv.style.display = 'block';
        studentSelect.setAttribute('required', 'required');
        sendBtnText.textContent = 'Send Message';
        if (sectionSelect.value) {
            loadStudents(sectionSelect.value);
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const individualRadio = document.querySelector('input[name="recipient_type"][value="individual"]');
    if (individualRadio && individualRadio.checked) {
        toggleRecipientType('individual');
    }
    
    // File preview
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const preview = document.getElementById('filePreview');
            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const tag = document.createElement('span');
                tag.className = 'inline-flex items-center gap-1 px-2 py-1 bg-slate-100 rounded text-xs text-slate-600';
                tag.innerHTML = `<i class="fas fa-file text-slate-400"></i>${file.name}`;
                preview.appendChild(tag);
            });
        });
    }
});

// Load students for selected section
async function loadStudents(sectionId) {
    if (!sectionId) return;
    
    const studentSelect = document.getElementById('studentSelect');
    const recipientType = document.querySelector('input[name="recipient_type"]:checked')?.value;
    
    if (recipientType === 'section') return;
    
    studentSelect.innerHTML = '<option value="">Loading students...</option>';
    studentSelect.disabled = true;
    
    try {
        const response = await fetch(`/teacher/communications/section/${sectionId}/students`);
        const students = await response.json();
        
        studentSelect.innerHTML = '<option value="">Select a student...</option>';
        students.forEach(student => {
            const option = document.createElement('option');
            option.value = student.id;
            option.textContent = `${student.name} (${student.lrn})`;
            studentSelect.appendChild(option);
        });
        studentSelect.disabled = false;
    } catch (error) {
        studentSelect.innerHTML = '<option value="">Error loading students</option>';
        studentSelect.disabled = false;
    }
}
</script>

</body>
</html>
