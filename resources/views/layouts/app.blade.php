<!DOCTYPE html>
<html>
<head>
    <title>Library Reservation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #8B1538;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Navigation */
        nav { 
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            margin-right: auto;
        }

        nav a { 
            color: white; 
            margin: 0 15px; 
            text-decoration: none; 
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        nav a:hover { 
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Container */
        .container { 
            max-width: 1000px; 
            margin: 30px auto; 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Typography */
        h1 { 
            color: #8B1538;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
        }

        h2 {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 1.8rem;
            font-weight: 600;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        table th, table td { 
            padding: 16px 20px; 
            text-align: left; 
            border-bottom: 1px solid #e2e8f0;
        }

        table th { 
            background: #8B1538;
            color: white; 
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table tr {
            transition: all 0.3s ease;
        }

        table tbody tr:hover { 
            background: #f7fafc;
            transform: scale(1.01);
        }

        table td {
            font-size: 0.95rem;
            color: #4a5568;
        }

        /* Buttons */
        .btn { 
            padding: 10px 20px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            text-decoration: none; 
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-block;
            margin: 2px;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-add { 
            background: #A91B5A;
            color: white; 
            margin-bottom: 20px;
            padding: 12px 24px;
            font-size: 1rem;
        }

        .btn-edit { 
            background: #C2185B;
            color: white; 
        }

        .btn-delete { 
            background: #D81B60;
            color: white; 
        }

        /* Forms */
        form { 
            margin-top: 30px; 
            background: #f7fafc;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
        }

        input, select { 
            padding: 12px 16px; 
            width: 100%; 
            border: 2px solid #e2e8f0; 
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #8B1538;
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
        }

        /* Status badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-available {
            background: #c6f6d5;
            color: #22543d;
        }

        .status-reserved {
            background: #fed7d7;
            color: #742a2a;
        }

        .status-borrowed {
            background: #feebc8;
            color: #7b341e;
        }

        /* Cards for better content organization */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Loading animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            nav .nav-content {
                flex-direction: column;
                gap: 10px;
            }

            h1 {
                font-size: 2rem;
            }

            table th, table td {
                padding: 12px 8px;
                font-size: 0.85rem;
            }

            .btn {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #8B1538;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #A91B5A;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-content">
            <div class="logo">Library System</div>
            <a href="{{ route('books.index') }}">Books</a>
            <a href="{{ route('reservations.index') }}">Reservations</a>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>