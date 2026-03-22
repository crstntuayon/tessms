<x-app-layout>
    <h2>Grades - {{ $section->name }}</h2>

    <form method="POST" action="{{ route('teacher.grades.store', $section) }}">
        @csrf

        <div class="mb-3">
            <label>Quarter</label>
            <select name="quarter" class="form-control">
                <option>1st</option>
                <option>2nd</option>
                <option>3rd</option>
                <option>4th</option>
            </select>
        </div>

        <table class="table table-bordered">
            <tr>
                <th>Student</th>
                @foreach($subjects as $subject)
                    <th>{{ $subject->name }}</th>
                @endforeach
            </tr>

            @foreach($students as $student)
            <tr>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                @foreach($subjects as $subject)
                    <td>
                        <input type="number" step="0.01"
                               name="grades[{{ $student->id }}][{{ $subject->id }}]"
                               class="form-control">
                    </td>
                @endforeach
            </tr>
            @endforeach
        </table>

        <button class="btn btn-success">Save Grades</button>
    </form>
</x-app-layout>
