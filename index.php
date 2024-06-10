<?php
include 'database.php';

// Fetch customers
$stmt = $conn->prepare("SELECT * FROM customers");
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Customer Management</h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCustomerModal"><i class="fas fa-user-plus"></i> Add Customer</button>

    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['name']); ?></td>
                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                    <td>
                        <button class="btn btn-warning edit-customer-btn" data-toggle="modal" data-target="#editCustomerModal"
                                data-id="<?php echo $customer['id']; ?>" data-name="<?php echo htmlspecialchars($customer['name']); ?>"
                                data-email="<?php echo htmlspecialchars($customer['email']); ?>" data-phone="<?php echo htmlspecialchars($customer['phone']); ?>">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <a href="delete_customer.php?id=<?php echo $customer['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer?')"><i class="fas fa-trash-alt"></i> Delete</a>
                        <a href="view_amortization.php?customer_id=<?php echo $customer['id']; ?>" class="btn btn-info"><i class="fas fa-eye"></i> View Amortization</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="add_customer.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="edit_customer.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editCustomerId" name="id">
                    <div class="form-group">
                        <label for="editCustomerName">Name</label>
                        <input type="text" class="form-control" id="editCustomerName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editCustomerEmail">Email</label>
                        <input type="email" class="form-control" id="editCustomerEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="editCustomerPhone">Phone</label>
                        <input type="text" class="form-control" id="editCustomerPhone" name="phone" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#editCustomerModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var phone = button.data('phone');

        var modal = $(this);
        modal.find('#editCustomerId').val(id);
        modal.find('#editCustomerName').val(name);
        modal.find('#editCustomerEmail').val(email);
        modal.find('#editCustomerPhone').val(phone);
    });
</script>

</body>
</html>
