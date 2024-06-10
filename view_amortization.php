<?php
include 'database.php';
include 'function.php';

$customer_id = $_GET['customer_id'];
$stmt = $conn->prepare("SELECT * FROM amortization WHERE customer_id = :customer_id");
$stmt->bindParam(':customer_id', $customer_id);
$stmt->execute();
$amortizations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM customers WHERE id = :id");
$stmt->bindParam(':id', $customer_id);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Amortization Schedule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Amortization Schedule for <?php echo htmlspecialchars($customer['name']); ?></h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAmortizationModal"><i class="fas fa-calendar-plus"></i> Add Amortization</button>
    <a href="index.php" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to Customers</a>

    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Amortization Details</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Principal Amount</th>
                        <th>Interest Rate</th>
                        <th>Loan Term (months)</th>
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($amortizations as $amortization): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($amortization['principal_amount']); ?></td>
                            <td><?php echo htmlspecialchars($amortization['interest_rate']); ?></td>
                            <td><?php echo htmlspecialchars($amortization['loan_term']); ?></td>
                            <td><?php echo htmlspecialchars($amortization['start_date']); ?></td>
                            <td>
                                <button class="btn btn-warning edit-amortization-btn" data-toggle="modal" data-target="#editAmortizationModal"
                                        data-id="<?php echo $amortization['id']; ?>" data-principal="<?php echo htmlspecialchars($amortization['principal_amount']); ?>"
                                        data-rate="<?php echo htmlspecialchars($amortization['interest_rate']); ?>" data-term="<?php echo htmlspecialchars($amortization['loan_term']); ?>"
                                        data-start="<?php echo htmlspecialchars($amortization['start_date']); ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="delete_amortization.php?id=<?php echo $amortization['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this amortization?')"><i class="fas fa-trash-alt"></i> Delete</a>
                            </td>
                        </tr>
                        <?php
                        // Call the function to calculate the amortization schedule
                        $schedule = calculateAmortization($amortization['principal_amount'], $amortization['interest_rate'], $amortization['loan_term']);
                        ?>
                        <tr>
                            <td colspan="5">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Month</th>
                                                <th>Payment</th>
                                                <th>Principal</th>
                                                <th>Interest</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($schedule as $payment): ?>
                                                <tr>
                                                    <td><?php echo $payment['month']; ?></td>
                                                    <td><?php echo number_format($payment['payment'], 2); ?></td>
                                                    <td><?php echo number_format($payment['principal'], 2); ?></td>
                                                    <td><?php echo number_format($payment['interest'], 2); ?></td>
                                                    <td><?php echo number_format($payment['balance'], 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Amortization Modal -->
<div class="modal fade" id="addAmortizationModal" tabindex="-1" role="dialog" aria-labelledby="addAmortizationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="add_amortization.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAmortizationModalLabel">Add Amortization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                    <div class="form-group">
                        <label for="principal_amount">Principal Amount</label>
                        <input type="number" class="form-control" id="principal_amount" name="principal_amount" required>
                    </div>
                    <div class="form-group">
                        <label for="interest_rate">Interest Rate (%)</label>
                        <input type="number" step="0.01" class="form-control" id="interest_rate" name="interest_rate" required>
                    </div>
                    <div class="form-group">
                        <label for="loan_term">Loan Term (months)</label>
                        <input type="number" class="form-control" id="loan_term" name="loan_term" required>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Amortization</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Amortization Modal -->
<div class="modal fade" id="editAmortizationModal" tabindex="-1" role="dialog" aria-labelledby="editAmortizationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="edit_amortization.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAmortizationModalLabel">Edit Amortization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editAmortizationId" name="id">
                    <div class="form-group">
                        <label for="editPrincipalAmount">Principal Amount</label>
                        <input type="number" class="form-control" id="editPrincipalAmount" name="principal_amount" required>
                    </div>
                    <div class="form-group">
                        <label for="editInterestRate">Interest Rate (%)</label>
                        <input type="number" step="0.01" class="form-control" id="editInterestRate" name="interest_rate" required>
                    </div>
                    <div class="form-group">
                        <label for="editLoanTerm">Loan Term (months)</label>
                        <input type="number" class="form-control" id="editLoanTerm" name="loan_term" required>
                    </div>
                    <div class="form-group">
                        <label for="editStartDate">Start Date</label>
                        <input type="date" class="form-control" id="editStartDate" name="start_date" required>
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
    $('#editAmortizationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var principal = button.data('principal');
        var rate = button.data('rate');
        var term = button.data('term');
        var start = button.data('start');

        var modal = $(this);
        modal.find('#editAmortizationId').val(id);
        modal.find('#editPrincipalAmount').val(principal);
        modal.find('#editInterestRate').val(rate);
        modal.find('#editLoanTerm').val(term);
        modal.find('#editStartDate').val(start);
    });
</script>

</body>
</html>
