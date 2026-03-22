<x-app-layout>
    <h2>My Grades</h2>

    @foreach($grades as $quarter => $records)
        <div class="card mb-4">
            <div class="card-header">
                {{ $quarter }} Quarter
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Subject</th>
                    <th>Grade</th>
                </tr>

                @foreach($records as $record)
                <tr>
                    <td>{{ $record->subject->name }}</td>
                    <td>{{ $record->grade }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</x-app-layout>
