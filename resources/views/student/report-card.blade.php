<x-app-layout>
    <div class="text-center mb-4">
        <h2>TUGAWE ELEMENTARY SCHOOL</h2>
        <p>Student Report Card</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
            <p><strong>Section:</strong> {{ $student->section->name }}</p>
        </div>
    </div>

    @foreach($report as $quarter => $data)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                {{ $quarter }} Quarter
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Subject</th>
                    <th>Grade</th>
                </tr>

                @foreach($data['grades'] as $record)
                <tr>
                    <td>{{ $record->subject->name }}</td>
                    <td>{{ $record->grade }}</td>
                </tr>
                @endforeach

                <tr>
                    <th>Average</th>
                    <th>{{ $data['average'] }}</th>
                </tr>
                <tr>
                    <th>Remarks</th>
                    <th>{{ $data['remarks'] }}</th>
                </tr>
            </table>
        </div>
    @endforeach

    <div class="text-center">
        <button onclick="window.print()" class="btn btn-success">
            Print Report Card
        </button>
    </div>
</x-app-layout>
