@extends('layouts.admin')

@section('title', 'Events')
@section('header-title', 'School Events')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header Actions --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">All Events</h1>
            <p class="text-sm text-slate-500 mt-1">Manage school events and activities</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/30">
            <i class="fas fa-plus"></i> New Event
        </a>
    </div>

    {{-- Stats Bar --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Total Events</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $events->count() }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Upcoming</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $events->where('date', '>=', now())->count() }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider">This Month</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $events->where('date', '>=', now()->startOfMonth())->where('date', '<=', now()->endOfMonth())->count() }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-rose-600 uppercase tracking-wider">Past Events</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $events->where('date', '<', now())->count() }}</p>
        </div>
    </div>

    {{-- Events List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-b border-emerald-100 text-emerald-700 text-sm flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($events->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-alt text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-slate-700">No events yet</h3>
                <p class="text-sm text-slate-400 mt-1">Create an event to share with students and teachers.</p>
                <a href="{{ route('admin.events.create') }}" class="mt-4 px-5 py-2.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                    <i class="fas fa-plus mr-1"></i> Create Event
                </a>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($events as $event)
                    <div class="p-5 hover:bg-slate-50 transition-colors {{ $event->date->isToday() ? 'bg-amber-50/30' : '' }}">
                        <div class="flex items-start gap-4">
                            {{-- Date Box --}}
                            <div class="w-16 h-16 rounded-xl flex flex-col items-center justify-center shrink-0 {{ $event->date->isPast() ? 'bg-slate-100 text-slate-500' : ($event->date->isToday() ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600') }}">
                                <span class="text-xs font-bold uppercase">{{ $event->date->format('M') }}</span>
                                <span class="text-xl font-bold">{{ $event->date->format('d') }}</span>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    @if($event->date->isToday())
                                        <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase tracking-wide">
                                            <i class="fas fa-star mr-1"></i>Today
                                        </span>
                                    @elseif($event->date->isPast())
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full uppercase tracking-wide">
                                            Completed
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full uppercase tracking-wide">
                                            Upcoming
                                        </span>
                                    @endif
                                    <span class="text-xs text-slate-400">
                                        {{ $event->date->format('l, Y') }}
                                    </span>
                                </div>

                                <h3 class="font-semibold text-slate-900">{{ $event->title }}</h3>
                                <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ Str::limit($event->description, 150) }}</p>

                                <div class="flex items-center gap-4 mt-3 text-xs text-slate-400">
                                    <span><i class="far fa-clock mr-1"></i>{{ $event->date->diffForHumans() }}</span>
                                    @if($event->created_at)
                                        <span><i class="fas fa-user mr-1"></i>Added {{ $event->created_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-1 shrink-0">
                                <a href="{{ route('admin.events.show', $event) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
