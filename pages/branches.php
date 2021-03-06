<?php
if (isset($_POST['create'])) {
    $db->run(
        'CALL create_branch(?,?,?);',
        $_SESSION['user_id'],
        trim($_POST['name']),
        trim($_POST['address'])
    );
}

if (isset($_POST['edit'])) {
    $db->update(
        'branches',
        ['name' => trim($_POST['name']), 'address' => trim($_POST['address'])],
        ['id' => $_POST['id']]
    );
}

if (isset($_POST['delete'])) {
    $db->delete(
        'branches',
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
                        <h6 class="h2 text-white d-inline-block mb-0">Branches</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary" data-toggle="modal"
                            data-target="#createBranchModal"
                            style="margin-right:20px; height:45px; border-radius:2em; color:#8898aa;">
                            + New Branch
                        </button>
                    </div>
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
                        <h3 class="mb-0">Branches Table</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" data-toggle="table" data-pagination="true"
                            data-page-size="7" data-pagination-parts="pageList" data-sort-name="id"
                            data-sort-order="asc" data-search="true" data-search-selector="#searchInput" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true">Branch ID</th>
                                    <th scope="col" data-field="name" data-sortable="true">Branch Name</th>
                                    <th scope="col" data-field="address" data-sortable="true">Branch Address</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php
                                $rows = $db->run(
                                    'SELECT b.id, b.name, b.address FROM branches b, users u, assignments a WHERE u.id = a.user_id and b.id = a.branch_id and u.id=?',
                                    $_SESSION['user_id']
                                );
                                foreach ($rows as $row) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" data-toggle="modal"
                                                    data-target="#editBranchModal<?php echo $row['id']; ?>">Edit</a>
                                                    <form role="form" action="" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>" >
                                                        <button name="delete" type="submit" class="dropdown-item">Delete</button>
                                                    </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal create branch -->
<div class="modal fade" id="createBranchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post">
                    <fieldset>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative modal-div-input">
                                <input class="form-control modal-div-input" placeholder="Branch Name" name="name"
                                    type="text">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative modal-div-input">
                                <input class="form-control modal-div-input" placeholder="Address" name="address"
                                    type="text">
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

<!-- Modal edit branch -->
<?php foreach ($rows as $row) { ?>
<div class="modal fade" id="editBranchModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post">
                    <fieldset>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative modal-div-input">
                                <input class="form-control modal-div-input" placeholder="Branch Name" name="name"
                                    type="text" value="<?php echo $row[
                                        'name'
                                    ]; ?>">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-merge input-group-alternative modal-div-input">
                                <input class="form-control modal-div-input" placeholder="Address" name="address"
                                    type="text" value="<?php echo $row[
                                        'address'
                                    ]; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input name="id" value="<?php echo $row[
                                'id'
                            ]; ?>" hidden>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button name="edit" type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<?php } ?>
