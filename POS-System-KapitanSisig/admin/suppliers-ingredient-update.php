<?php include('includes/header.php'); ?>

<?php
// Check if supplier ID is provided
if (isset($_GET['id'])) {
    $supplierId = intval($_GET['id']);

    // Fetch supplier details
    $supplierQuery = "SELECT * FROM suppliers WHERE id = $supplierId";
    $supplierResult = mysqli_query($conn, $supplierQuery);
    $supplier = mysqli_fetch_assoc($supplierResult);

    // Fetch all ingredients for the dropdown
    $allIngredientsQuery = "SELECT id, name FROM ingredients";
    $allIngredientsResult = mysqli_query($conn, $allIngredientsQuery);

    // Fetch all UoMs for the dropdown
    $uomQuery = "SELECT id, uom_name FROM units_of_measure";
    $uomResult = mysqli_query($conn, $uomQuery);

    // Fetch ingredients associated with the supplier
    $ingredientsQuery = "
        SELECT supplier_ingredients.id AS supplier_ingredient_id, 
               ingredients.name AS ingredient_name, 
               supplier_ingredients.unit_id, 
               supplier_ingredients.price, 
               uom.uom_name 
        FROM supplier_ingredients
        JOIN ingredients ON supplier_ingredients.ingredient_id = ingredients.id
        LEFT JOIN units_of_measure uom ON supplier_ingredients.unit_id = uom.id
        WHERE supplier_ingredients.supplier_id = $supplierId
    ";
    $ingredientsResult = mysqli_query($conn, $ingredientsQuery);
    $hasIngredients = mysqli_num_rows($ingredientsResult) > 0;
} else {
    header('Location: suppliers.php');
    exit;
}
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Update Supplier Ingredients
                <a href="suppliers-ingredient-view.php?id=<?= urlencode($supplierId); ?>" class="btn btn-outline-secondary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php if ($supplier): ?>
                <form action="code.php" method="POST">
                    <input type="hidden" name="supplier_id" value="<?= htmlspecialchars($supplierId); ?>">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ingredient Name</th>
                                <th>Unit of Measure</th>
                                <th>Price</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($hasIngredients): ?>
                                <?php while ($ingredient = mysqli_fetch_assoc($ingredientsResult)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ingredient['ingredient_name']); ?></td>
                                        <td>
                                            <select name="unit_id[]" class="form-select" required>
                                                <?php
                                                mysqli_data_seek($uomResult, 0); // Reset UoM result pointer
                                                while ($uom = mysqli_fetch_assoc($uomResult)) {
                                                    $selected = ($uom['id'] == $ingredient['unit_id']) ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($uom['id']) . '" ' . $selected . '>' . htmlspecialchars($uom['uom_name']) . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="price[]" class="form-control" value="<?= htmlspecialchars($ingredient['price']); ?>" min="0" step="0.01" required>
                                        </td>
                                        <td>
                                            <input type="hidden" name="ingredient_id[]" value="<?= htmlspecialchars($ingredient['supplier_ingredient_id']); ?>">
                                            <input type="checkbox" name="delete_ingredient[]" value="<?= htmlspecialchars($ingredient['supplier_ingredient_id']); ?>"> Remove Ingredient
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No ingredients found for this supplier.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Add New Ingredient Section -->
                    <h5 class="mt-4">Add New Ingredients</h5>
                    <table id="newIngredientsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ingredient</th>
                                <th>Unit of Measure</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- New ingredient rows will be appended here -->
                        </tbody>
                    </table>

                    <button type="button" id="addRow" class="btn btn-outline-success mt-2">Add Ingredient</button>
                    <button type="submit" name="updateSupplierIngredient" class="btn btn-outline-primary mt-2">Update Ingredients</button>
                </form>
            <?php else: ?>
                <h6 class="text-danger">Supplier not found.</h6>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script>
// Add new row for new ingredients
document.getElementById('addRow').addEventListener('click', function () {
    var table = document.getElementById('newIngredientsTable').getElementsByTagName('tbody')[0];
    var newRow = table.insertRow();
    newRow.innerHTML = `
        <td>
            <select name="new_ingredient_id[]" class="form-select" required>
                <?php
                mysqli_data_seek($allIngredientsResult, 0); // Reset ingredient result pointer
                while ($ingredient = mysqli_fetch_assoc($allIngredientsResult)) {
                    echo '<option value="' . htmlspecialchars($ingredient['id']) . '">' . htmlspecialchars($ingredient['name']) . '</option>';
                }
                ?>
            </select>
        </td>
        <td>
            <select name="new_unit_id[]" class="form-select" required>
                <?php
                mysqli_data_seek($uomResult, 0); // Reset UoM result pointer
                while ($uom = mysqli_fetch_assoc($uomResult)) {
                    echo '<option value="' . htmlspecialchars($uom['id']) . '">' . htmlspecialchars($uom['uom_name']) . '</option>';
                }
                ?>
            </select>
        </td>
        <td>
            <input type="number" name="new_price[]" class="form-control" placeholder="Enter Price" min="0" step="0.01" required>
        </td>
        <td>
            <button type="button" class="btn btn-danger removeRow">Remove</button>
        </td>
    `;
});

// Remove row for new ingredients
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('removeRow')) {
        var row = e.target.closest('tr');
        row.parentNode.removeChild(row);
    }
});
</script>
