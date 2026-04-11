@extends('layouts.admin')

@section('title', $event->title)
@section('header-title', 'Event Details')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.events.index') }}" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900">{{ $event->title }}</h1>
            <p class="text-sm text-slate-500">Event details and information</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.edit', $event) }}" class="px-4 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-sm font-medium text-rose-700 bg-rose-50 rounded-xl hover:bg-rose-100 transition-colors">
                    <i class="fas fa-trash mr-2"></i>Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Event Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        {{-- Date Banner --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-white/20 rounded-2xl flex flex-col items-center justify-center backdrop-blur-sm">
                    <span class="text-sm font-bold uppercase">{{ $event->date->format('M') }}</span>
                    <span class="text-3xl font-bold">{{ $event->date->format('d') }}</span>
                </div>
                <div>
                    <p class="text-white/80 text-sm">{{ $event->date->format('l, F Y') }}</p>
                    <p class="text-2xl font-bold">{{ $event->title }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($event->date->isToday())
                            <span class="px-2 py-0.5 bg-amber-400 text-amber-900 text-xs font-bold rounded-full">
                                <i class="fas fa-star mr-1"></i>Today
                            </span>
                        @elseif($event->date->isPast())
                            <span class="px-2 py-0.5 bg-slate-400/50 text-white text-xs font-bold rounded-full">
                                Completed
                            </span>
                        @else
                            <span class="px-2 py-0.5 bg-emerald-400 text-emerald-900 text-xs font-bold rounded-full">
                                Upcoming
                            </span>
                        @endif
                        <span class="text-white/70 text-xs">
                            <i class="far fa-clock mr-1"></i>{{ $event->date->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="p-6">
            <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-3">Description</h3>
            <div class="prose prose-slate max-w-none">
                @if($event->description)
                    <p class="text-slate-600 whitespace-pre-line">{{ $event->description }}</p>
                @else
                    <p class="text-slate-400 italic">No description provided.</p>
                @endif
            </div>
        </div>

        {{-- Footer Info --}}
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            <div class="flex items-center justify-between text-sm text-slate-500">
                <div class="flex items-center gap-4">
                    <span><i class="fas fa-calendar-plus mr-1"></i>Created {{ $event->created_at->diffForHumans() }}</span>
                    @if($event->updated_at && $event->updated_at->ne($event->created_at))
                        <span><i class="fas fa-edit mr-1"></i>Updated {{ $event->updated_at->diffForHumans() }}</span>
                    @endif
                </div>
                <span class="text-xs">Event ID: #{{ $event->id }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
