<div class="dashboard-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>



<div>
    <form class="form-create-role">
        <div class="card p-3 mb-4">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="Username" name="name" required>
            </div>

            <div class="mb-3">
                <h5>Permissions</h5>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Section</th>
                                <th>All</th>
                                <th>Index</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Roles</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Users</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                            <tr>
                                <td>Attributes</td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td><input type="checkbox" class="form-check-input"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>
</div>