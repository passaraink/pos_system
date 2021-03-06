<?php

if (isset($_POST['create'])) {
    $db->insert(
        'products',
        [
            'name' => trim($_POST['name']),
            'category' => $_POST['category'],
            'sell_price' => $_POST['sell_price'],
            'buy_price' => $_POST['buy_price']
        ]
    );
} 

if (isset($_POST['edit'])) {
    $db->update(
        'products',
        [
            'name' => trim($_POST['name']),
            'category' => $_POST['category'],
            'sell_price' => trim($_POST['sell_price']),
            'buy_price' => $_POST['buy_price'],
        ],
        ['id' => $_POST['id']]
    );
} 

if (isset($_POST['delete'])) {
    $db->delete(
        'products',
        ['id' => $_POST['id']]
    );
} 
?>


<!-- Main content -->
<div class="main-content" id="panel">
<!-- Topnav -->
<?php include 'includes/nav-top.php'; ?>
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Products</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <!-- Button trigger modal -->
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createProductModal" style="margin-right:20px; height:45px; border-radius:2em; color:#8898aa;">
              + New Product
            </button>
          <div class="col-lg-6 col-i5 text-right branch-filter" style="margin-left:10px;">
            <select class="form-control branch-filter" style="margin-left:20px;" id="filtercategory">
                <option value="ALL" selected> ALL </option>
                <option value="ELECTRONICS"> ELECTRONICS </option>
                <option value="DRINKS"> DRINKS </option>
                <option value="SNACKS"> SNACKS </option>
                <option value="MEDICAL"> MEDICAL </option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Create Product -->
<div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form role="form" action="" method="post">
            <fieldset>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative modal-div-input">
                        <input class="form-control modal-div-input" placeholder="Product Name" name="name" type="text">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <select class="form-control create-acc-select modal-div-input" name="category" required>
                        <option value="" disabled selected> Choose Product Category </option>
                        <option value="ELECTRONICS"> ELECTRONICS </option>
                        <option value="DRINKS"> DRINKS </option>
                        <option value="SNACKS"> SNACKS </option>
                        <option value="MEDICAL"> MEDICAL </option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative modal-div-input">
                        <input class="form-control modal-div-input" placeholder="Sale Price" name="sell_price" type="number">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative modal-div-input">
                        <input class="form-control modal-div-input" placeholder="Buy Price" name="buy_price" type="number">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button name="create" type="submit" class="btn btn-primary">Create</button>
                </div>
            </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col">
      <div class="card">
        <!-- Card header -->
        <div class="card-header border-0">
          <h3 class="mb-0">Products Table</h3>
        </div>
        <!-- Light table -->
        <div class="table-responsive">
          <table class="table align-items-center table-flush" data-toggle="table" data-pagination="true" data-page-size="7" data-pagination-parts="pageList" data-sort-name="id"
  data-sort-order="asc" data-search="true" data-search-selector="#searchInput" id="myTable">
            <thead class="thead-light">
              <tr>
                <th scope="col" data-field="id" data-sortable="true">Product ID</th>
                <th scope="col" data-field="name" data-sortable="true">Product Name</th>
                <th scope="col" data-field="category" style="cursor:default;">Product Category</th>
                <th scope="col" data-field="sell-price" data-sortable="true">Sale Price</th>
                <th scope="col" data-field="buy-price" data-sortable="true">Buy Price</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
            <?php
            $rows = $db->run(
                'SELECT p.id, p.name, p.category, p.sell_price, p.buy_price FROM products p'
            );
            foreach ($rows as $row) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['sell_price']; ?></td>
                    <td><?php echo $row['buy_price']; ?></td>
                    <td class="text-right">
                    <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" data-toggle="modal" data-target="#editProductsModal<?php echo $row['id']; ?>">Edit</a>
                        <form role="form" action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                            <button name="delete" type="submit" class="dropdown-item">Delete</button>
                        </form>
                        </div>
                    </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<?php foreach ($rows as $row) { ?>
<!-- Modal edit product-->
<div class="modal fade" id="editProductsModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form role="form" action="" method="post">
            <fieldset>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative modal-div-input">
                        <input class="form-control modal-div-input" placeholder="Product Name" name="name" type="text" value="<?php echo $row['name']; ?>">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <select class="form-control create-acc-select modal-div-input" name="category" required>
                        <option value="ELECTRONICS" <?php if ($row['category'] == 'ELECTRONICS') {echo 'selected';} ?>> ELECTRONICS </option>
                        <option value="DRINKS" <?php if ($row['category'] == 'DRINKS') {echo 'selected';} ?>> DRINKS </option>
                        <option value="SNACKS" <?php if ($row['category'] == 'SNACKS') {echo 'selected';} ?>> SNACKS </option>
                        <option value="MEDICAL" <?php if ($row['category'] == 'MEDICAL') {echo 'selected';} ?>> MEDICAL </option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative modal-div-input">
                        <input class="form-control modal-div-input" placeholder="Sale Price" name="sell_price" type="number" value="<?php echo $row['sell_price']; ?>">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="input-group input-group-merge input-group-alternative modal-div-input">
                        <input class="form-control modal-div-input" placeholder="Buy Price" name="buy_price" type="number" value="<?php echo $row['buy_price']; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button name="edit" type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>

<?php } ?>

<script>
$(function() {
    var $table = $('#myTable');
    var $selector = $('#filtercategory');

    $selector.change(function () {
        var $category = $(this).children('option:selected').val();
        if ($category != 'ALL') $table.bootstrapTable('filterBy', {category: $category});
        else $table.bootstrapTable('filterBy', {});
    });
});
</script>
