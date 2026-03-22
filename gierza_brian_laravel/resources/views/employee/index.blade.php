<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
    <h1>Employees</h1>

    <!-- Employee Form -->
    <form action="/employee123" method="POST" class="product-form">
        @csrf

        <div class="form-group">
            <label for="firstname123">First Name:</label>
            <input type="text" id="firstname123" name="firstname123">
        </div>

        <div class="form-group">
            <label for="lastname123">Last Name:</label>
            <input type="text" id="lastname123" name="lastname123">
        </div>

        <div class="form-group">
            <label for="job123">Job:</label>
            <input type="text" id="job123" name="job123">
        </div>

        <div class="form-group">
            <label for="salary123">Salary:</label>
            <input type="text" id="salary123" name="salary123">
        </div>

        <button type="submit" class="btn-submit">Save</button>
    </form>

    <hr>

   
    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Job</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->FirstName }}</td>
                    <td>{{ $item->LastName }}</td>
                    <td>{{ $item->Job }}</td>
                    <td>{{ $item->Salary }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>