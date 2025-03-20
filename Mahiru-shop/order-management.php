<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Mahiru Shop</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="./css/order.css" />
  </head>
  <body>
    <header>
      <div class="container">
        <h1 class="logo">MAHIRU<span>.</span> ADMIN</h1>
        <nav>
          <ul>
            <li><a href="./admin.php">Dashboard</a></li>
            <li><a href="./user-management.php">User</a></li>
            <li><a href="./order-management.php">Orders</a></li>
            <li><a href="./product-management.php">Product</a></li>
            <li><a href="./business_performance.php">Statistic</a></li>
          </ul>
        </nav>
        <div class="user-info">
          <div class="user-icon">
            <i data-lucide="user-circle"></i>
          </div>
          <span class="admin-name">Admin: Hatsu</span>
          <a href="./loginad.php" class="logout">Log out</a>
        </div>
      </div>
    </header>

    <main>
      <div class="container">
        <div class="admin-panel">
          <div class="admin-sidebar">
            <h2>Order Management</h2>
            <ul>
              <li><a href="./order-management.php">Order List</a></li>
            </ul>
          </div>
          <section class="card" style="margin-bottom: 0px">
            <div class="filters">
              <div class="filters-row">
                <div class="filter-group">
                  <label class="filter-label">Date Range</label>
                  <div class="date-range">
                    <div>
                      <label>From:</label>
                      <input type="date" id="start-date" name="start-date" />
                    </div>
                    <div class="date-to">
                      <label>To:</label>
                      <input type="date" id="end-date" name="end-date" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="filters-row">
                <div class="filter-group">
                  <label class="filter-label">Status</label>
                  <select id="order-status" name="order-status">
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="delivered">Delivered</option>
                    <option value="canceled">Canceled</option>
                  </select>
                </div>

                <div class="filter-group">
                  <label class="filter-label">Address</label>
                  <select name="Address" id="Address">
                    <option value="All Address">Show All</option>
                    <option value="1">District 1</option>
                    <option value="2">District 2</option>
                    <option value="3">District 3</option>
                  </select>
                </div>

                <button class="btn">Search</button>
              </div>
            </div>

            <table>
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Address</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#2532</td>
                  <td>Jane Doe</td>
                  <td>2023-06-01</td>
                  <td>District 1</td>
                  <td>$150.00</td>
                  <td>Processing</td>
                  <td>
                    <a href="./detail-order.php" class="btn">View Details</a>
                  </td>
                </tr>
                <tr>
                  <td>#2533</td>
                  <td>Tsukishiro Yanagi</td>
                  <td>2023-06-02</td>
                  <td>District 2</td>
                  <td>$200.00</td>
                  <td>Confirmed</td>
                  <td>
                    <a href="./detail-order.php" class="btn">View Details</a>
                  </td>
                </tr>
                <tr>
                  <td>#2534</td>
                  <td>Burnice White</td>
                  <td>2023-06-03</td>
                  <td>District 3</td>
                  <td>$180.00</td>
                  <td>Delivered</td>
                  <td>
                    <a href="./detail-order.php" class="btn">View Details</a>
                  </td>
                </tr>
                <tr>
                  <td>#2532</td>
                  <td>Nicole Demara</td>
                  <td>2023-06-01</td>
                  <td>District 1</td>
                  <td>$150.00</td>
                  <td>Processing</td>
                  <td>
                    <a href="./detail-order.php" class="btn">View Details</a>
                  </td>
                </tr>
                <tr>
                  <td>#2533</td>
                  <td>Ceaser King</td>
                  <td>2023-06-02</td>
                  <td>District 2</td>
                  <td>$200.00</td>
                  <td>Confirmed</td>
                  <td>
                    <a href="./detail-order.php" class="btn">View Details</a>
                  </td>
                </tr>
                <tr>
                  <td>#2534</td>
                  <td>Luciana de Montefio</td>
                  <td>2023-06-03</td>
                  <td>District 3</td>
                  <td>$180.00</td>
                  <td>Delivered</td>
                  <td>
                    <a href="./detail-order.php" class="btn">View Details</a>
                  </td>
                </tr>
                <tr>
                  <td>#2534</td>
                  <td>Piper Wheel</td>
                  <td>2023-06-03</td>
                  <td>District 3</td>
                  <td>$180.00</td>
                  <td>Delivered</td>
                  <td>
                    <a href="./detail-order.php" class="btn">View Details</a>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="pagination">
              <a href="#">&laquo;</a>
              <a href="#" class="active">1</a>
              <a href="#">2</a>
              <a href="#">3</a>
              <a href="#">4</a>
              <a href="#">5</a>
              <a href="#">&raquo;</a>
          </div>
          </section>
        </div>
      </div>
    </main>

    <footer>
      <div class="container">
          <p>&copy;Mahiru Shop. We are pleased to serve you.</p>
      </div>
  </footer>

    <script>
      lucide.createIcons();
    </script>
  </body>
</html>
