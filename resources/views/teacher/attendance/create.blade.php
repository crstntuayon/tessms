<x-app-layout>
    <h2>Attendance - {{ $section->name }}</h2>

    <form method="POST" action="{{ route('teacher.attendance.store', $section) }}">
        @csrf

        <table class="table table-bordered">
            <tr>
                <th>Student</th>
                <th>Status</th>
            </tr>

            @foreach($students as $student)
            <tr>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                <td>
                    <select name="status[{{ $student->id }}]" class="form-control">
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Late">Late</option>
                    </select>
                </td>
            </tr>
            @endforeach
        </table>

        <button class="btn btn-success">Save Attendance</button>
    </form>
</x-app-layout>
