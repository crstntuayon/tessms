<x-app-layout>
    <h2>Attendance</h2>

    @foreach($sections as $section)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $section->name }}</h5>
                <a href="{{ route('teacher.attendance.create', $section) }}"
                   class="btn btn-primary">
                    Take Attendance
                </a>
            </div>
        </div>
    @endforeach
</x-app-layout>
