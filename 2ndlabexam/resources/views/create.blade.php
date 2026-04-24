<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Rice - Rice Shop</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        h1 { color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 100px; }
        .btn { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #218838; }
        .btn-secondary { background: #6c757d; }
        .nav { background: #333; padding: 15px; margin-bottom: 20px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('rices.index') }}">Rice Products</a>
        <a href="{{ route('orders.index') }}">Orders</a>
        <a href="{{ route('payments.index') }}">Payments</a>
    </div>
    <div class="container">
        <h1>Create New Rice</h1>
        
        <form action="{{ route('rices.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            
            <div class="form-group">
                <label for="price_per_kg">Price per KG:</label>
                <input type="number" step="0.01" name="price_per_kg" id="price_per_kg" required>
            </div>
            
            <div class="form-group">
                <label for="stock">Stock (KG):</label>
                <input type="number" name="stock" id="stock" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
            </div>
            
            <button type="submit" class="btn">Create</button>
            <a href="{{ route('rices.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>