
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tables Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: white;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            padding: 0 20px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 600;
            color: #e74c3c;
        }

        .logo::before {
            content: "🍕";
            font-size: 24px;
        }

        .nav-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #666;
            cursor: pointer;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            text-decoration: none;
        }

        .nav-item:hover {
            background: #f8f8f8;
            color: #333;
        }

        .nav-item.active {
            background: #fff5f5;
            color: #e74c3c;
            border-left-color: #e74c3c;
        }

        .nav-item::before {
            font-size: 18px;
        }

        .nav-item.dashboard::before { content: "📊"; }
        .nav-item.foods::before { content: "🍽️"; }
        .nav-item.addons::before { content: "➕"; }
        .nav-item.menus::before { content: "📋"; }
        .nav-item.tables::before { content: "🪑"; }
        .nav-item.qr::before { content: "📱"; }
        .nav-item.orders::before { content: "🛒"; }
        .nav-item.logout::before { content: "🚪"; }

        .nav-divider {
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 240px;
            padding: 20px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .breadcrumb {
            color: #999;
            font-size: 14px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .user-profile:hover {
            background: #f0f0f0;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e74c3c;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Content Section */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .content-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 600;
            color: #e74c3c;
        }

        .content-title::before {
            content: "🪑";
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #e74c3c;
            color: white;
        }

        .btn-primary:hover {
            background: #c0392b;
        }

        .btn-secondary {
            background: white;
            color: #666;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background: #f8f8f8;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        /* Search */
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-box::before {
            content: "🔍";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-label {
            color: #999;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 600;
            color: #333;
        }

        .stat-card.available .stat-value { color: #27ae60; }
        .stat-card.occupied .stat-value { color: #e74c3c; }
        .stat-card.reserved .stat-value { color: #f39c12; }
        .stat-card.maintenance .stat-value { color: #95a5a6; }

        /* Table Grid */
        .tables-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .table-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
            position: relative;
        }

        .table-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .table-number {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.available {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.occupied {
            background: #f8d7da;
            color: #721c24;
        }

        .status-badge.reserved {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.maintenance {
            background: #e2e3e5;
            color: #383d41;
        }

        .table-info {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: #666;
            font-size: 14px;
        }

        .table-actions {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }

        .action-btn {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 30px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 4px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex flex-col">
            <div class="p-6">
                <div class="flex items-center space-x-2 text-red-500 text-xl font-bold">
                    <i class="fas fa-utensils"></i>
                    <span>Resta!</span>
                </div>
            </div>
            
            <nav class="mt-6 flex-1">
                
                <a href="{{ route('admin.foods') }}" class="flex items-center px-6 py-3 bg-red-50 text-red-500 border-r-4 border-red-500">
                    <i class="fas fa-drumstick-bite mr-3"></i>
                    <span>Foods</span>
                </a>
               
                <a href="{{route('admin.tables')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-table mr-3"></i>
                    <span>Tables</span>
                </a>
                <a href="{{route('admin.approvals')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-qrcode mr-3"></i>
                    <span>Approvals</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    <span>Orders</span>
                </a>
            </nav>

            <div class="border-t mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center space-x-2 text-gray-500">
                        <span>Dashboard</span>
                        <span>/</span>
                        <span class="text-gray-900">Tables</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.profile') }}" class="flex items-center space-x-2 hover:text-red-500">
                            <span class="text-gray-700">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                            @else
                            <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                            @endif
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-8">
                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                <!-- Page Title and Actions -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-drumstick-bite text-red-500 text-xl"></i>
                        <h1 class="text-2xl font-semibold text-gray-800">Tables</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                         <button class="btn btn-primary" onclick="openAddModal()">
                        ➕ Add New 
                    </button>
                    </div>
                </div>

                

                <!-- Food List Table -->
                <div class="bg-white rounded-lg shadow-sm">
                    <!-- Search Bar -->
                    <div class="p-6 border-b">
                        <form method="GET" action="{{ route('admin.tables') }}">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Name" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                        </form>
                    </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card available">
                    <div class="stat-label">Available</div>
                    <div class="stat-value" id="statAvailable">{{ $tables->where('status', 'available')->count() }}</div>
                </div>
                <div class="stat-card occupied">
                    <div class="stat-label">Occupied</div>
                    <div class="stat-value" id="statOccupied">{{ $tables->where('status', 'occupied')->count() }}</div>
                </div>
                <div class="stat-card reserved">
                    <div class="stat-label">Reserved</div>
                    <div class="stat-value" id="statReserved">{{ $tables->where('status', 'reserved')->count() }}</div>
                </div>
                <div class="stat-card maintenance">
                    <div class="stat-label">Maintenance</div>
                    <div class="stat-value" id="statMaintenance">{{ $tables->where('status', 'maintenance')->count() }}</div>
                </div>
            </div>

            
            <!-- Tables Grid -->
            <div class="tables-grid" id="tablesGrid">
                @forelse($tables as $table)
                <div class="table-card" data-table-id="{{ $table->id }}" data-search="{{ strtolower($table->table_number . ' ' . $table->location) }}">
                    <div class="table-header">
                        <div class="table-number">{{ $table->table_number }}</div>
                        <span class="status-badge {{ $table->status }}">
                            {{ $table->status_icon }} {{ ucfirst($table->status) }}
                        </span>
                    </div>
                    <div class="table-info">
                        <div class="info-row">
                            <span>👥</span>
                            <span>Capacity: {{ $table->capacity }} persons</span>
                        </div>
                        
                        @if($table->notes)
                        <div class="info-row">
                            <span>📝</span>
                            <span>{{ Str::limit($table->notes, 50) }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="table-actions">
                        <button class="action-btn btn-success" onclick="quickStatusChange({{ $table->id }}, '{{ $table->status }}')">
                            Change Status
                        </button>
                        <button class="action-btn btn-warning" onclick="editTable({{ $table->id }})">
                            ✏️ Edit
                        </button>
                        <button class="action-btn btn-danger" onclick="deleteTable({{ $table->id }})">
                            🗑️ Delete
                        </button>
                    </div>
                </div>
                @empty
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div class="empty-state-icon">🪑</div>
                    <h3>No Tables Yet</h3>
                    <p>Start by adding your first table</p>
                    
                </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Add/Edit Table Modal -->
    <div class="modal" id="tableModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add New Table</h2>
                <button class="close-btn" onclick="closeTableModal()">×</button>
            </div>
            <form id="tableForm" onsubmit="saveTable(event)">
                <input type="hidden" id="tableId">
                
                <div class="form-group">
                    <label>Table Number *</label>
                    <input type="text" id="tableNumber" required placeholder="e.g., 1, A1, VIP-01">
                    <div class="error-message" id="errorTableNumber"></div>
                </div>

                <div class="form-group">
                    <label>Capacity (persons) *</label>
                    <input type="number" id="tableCapacity" required min="1" max="20" placeholder="e.g., 4">
                    <div class="error-message" id="errorCapacity"></div>
                </div>

                <div class="form-group">
                    <label>Status *</label>
                    <select id="tableStatus" required>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    <div class="error-message" id="errorStatus"></div>
                </div>


                <div class="form-group">
                    <label>Notes</label>
                    <textarea id="tableNotes" placeholder="Any additional information..."></textarea>
                    <div class="error-message" id="errorNotes"></div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeTableModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Table</button>
                </div>
            </form>
        </div>
        
    </div>

    <script>
        // CSRF Token Setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Filter tables
        function filterTables() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const tableCards = document.querySelectorAll('.table-card');
            
            tableCards.forEach(card => {
                const searchData = card.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Show alert message
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            
            alertContainer.innerHTML = `
                <div class="alert ${alertClass} show">
                    ${message}
                </div>
            `;
            
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 3000);
        }

        // Open add modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Table';
            document.getElementById('tableForm').reset();
            document.getElementById('tableId').value = '';
            clearErrors();
            document.getElementById('tableModal').classList.add('active');
        }

        // Close modal
        function closeTableModal() {
            document.getElementById('tableModal').classList.remove('active');
            clearErrors();
        }

        // Clear error messages
        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        }

        // Edit table
        async function editTable(tableId) {
            try {
                const response = await fetch(`/admin/tables/${tableId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('modalTitle').textContent = 'Edit Table';
                    document.getElementById('tableId').value = data.table.id;
                    document.getElementById('tableNumber').value = data.table.table_number;
                    document.getElementById('tableCapacity').value = data.table.capacity;
                    document.getElementById('tableStatus').value = data.table.status;
                    document.getElementById('tableLocation').value = data.table.location || '';
                    document.getElementById('tableNotes').value = data.table.notes || '';
                    
                    clearErrors();
                    document.getElementById('tableModal').classList.add('active');
                } else {
                    showAlert('Failed to load table data', 'error');
                }
            } catch (error) {
                showAlert('Error loading table data', 'error');
                console.error('Error:', error);
            }
        }

        // Save table (create or update)
        async function saveTable(event) {
            event.preventDefault();
            clearErrors();
            
            const tableId = document.getElementById('tableId').value;
            const url = tableId ? `/admin/tables/${tableId}` : '/admin/tables';
            const method = tableId ? 'PUT' : 'POST';
            
            const formData = {
                table_number: document.getElementById('tableNumber').value,
                capacity: document.getElementById('tableCapacity').value,
                status: document.getElementById('tableStatus').value,
                location: document.getElementById('tableLocation').value,
                notes: document.getElementById('tableNotes').value
            };
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert(data.message, 'success');
                    closeTableModal();
                    location.reload();
                } else {
                    // Show validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorElement = document.getElementById(`error${key.charAt(0).toUpperCase() + key.slice(1).replace('_', '')}`);
                            if (errorElement) {
                                errorElement.textContent = data.errors[key][0];
                            }
                        });
                    }
                    showAlert('Please check the form for errors', 'error');
                }
            } catch (error) {
                showAlert('Error saving table', 'error');
                console.error('Error:', error);
            }
        }

        // Delete table
        async function deleteTable(tableId) {
            if (!confirm('Are you sure you want to delete this table? This action cannot be undone.')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/tables/${tableId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert(data.message, 'success');
                    location.reload();
                } else {
                    showAlert('Failed to delete table', 'error');
                }
            } catch (error) {
                showAlert('Error deleting table', 'error');
                console.error('Error:', error);
            }
        }

        // Quick status change
        async function quickStatusChange(tableId, currentStatus) {
            const statuses = ['available', 'occupied', 'reserved', 'maintenance'];
            const statusLabels = {
                'available': '✓ Available',
                'occupied': '● Occupied',
                'reserved': '◷ Reserved',
                'maintenance': '⚠ Maintenance'
            };
            
            let options = statuses.map(status => 
                `<option value="${status}" ${status === currentStatus ? 'selected' : ''}>${statusLabels[status]}</option>`
            ).join('');
            
            const newStatus = prompt(`Change table status:\n\nCurrent: ${statusLabels[currentStatus]}\n\nEnter new status (available/occupied/reserved/maintenance):`, currentStatus);
            
            if (!newStatus || newStatus === currentStatus) {
                return;
            }
            
            if (!statuses.includes(newStatus)) {
                showAlert('Invalid status. Use: available, occupied, reserved, or maintenance', 'error');
                return;
            }
            
            try {
                const response = await fetch(`/admin/tables/${tableId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert(data.message, 'success');
                    location.reload();
                } else {
                    showAlert('Failed to update status', 'error');
                }
            } catch (error) {
                showAlert('Error updating status', 'error');
                console.error('Error:', error);
            }
        }
    </script>
</body>
</html>