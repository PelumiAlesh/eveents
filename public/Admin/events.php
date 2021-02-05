<?php require_once('../../private/initialize.php'); ?>

<?php

$events = fetch_all_events();
$event_type_list = fetch_types();
$currentEvent = '';


if (isset($_POST['edit_event'])) {
    $title = $_POST['title_modal'];
    $desc = $_POST['desc_modal'];
    $id = $_POST['id_modal'];
    $type = $_POST['type_modal'];
    $data = ['title' => $title, 'desc' => $desc, 'id' => $id, 'type_id' => $type];
    update_event($data);
}
if (isset($_POST['add_event'])) {
    $title = $_POST['title_modal'];
    $desc = $_POST['desc_modal'];
//    $type = $_POST['type_modal'];
    $data = ['title' => $title, 'desc' => $desc];
    insert_event($data);
}
if (isset($_POST['add_type'])) {
    $type = $_POST['type_name_modal'];
    insert_type($type);
}

function getTypes($typeString) {
    $typeArray = explode(',',$typeString);
    $intersectArray = array_unique($typeArray);
    return implode(',', $intersectArray);
}
?>

<?php $page_title = 'Home'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
    <div class="contain">
        <div class="column">
            <div class="table-top">
                <h4 class="heading">Events</h4>
                <button type="button" class="btn view-btn btn-primary" data-toggle="modal" data-target="#add-event">
                    New Event
                </button>
                <button type="button" class="btn view-btn btn-secondary" data-toggle="modal" data-target="#add-type">
                    New Type
                </button>
            </div>
            <div class="column-responsive column-80">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($event = mysqli_fetch_assoc($events)) { ?>
                        <tr>
                            <td><?php echo h($event['id']); ?></td>
                            <td><?php echo h($event['name']); ?></td>
                            <td><?php echo substr(h($event['desc']), 0, 100) . '...'; ?></td>
                            <td><?php echo h(getTypes($event['types'])); ?></td>
                            <td><?php echo h($event['created_at']); ?></td>
                            <td>
                                <button
                                    type="button"
                                    class="btn view-btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#event-data"
                                    data-id="<?= $event['id']; ?>"
                                    data-desc="<?= $event['desc']; ?>"
                                    data-typeName="<?= h(getTypes($event['types'])); ?>"
                                    data-eventName="<?= $event['name']; ?>"
                                >
                                    View
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="event-data" tabindex="-1" role="dialog" aria-labelledby="event-data" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  action="" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title_modal" class="form-control" id="title_modal" aria-describedby="emailHelp" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea class="form-control" id="desc_modal" name="desc_modal" placeholder="Description" rows="5"></textarea>
                            </div>
                            <div class="form-group" style="display: none">
                                <input class="form-control" id="id_modal" name="id_modal" />
                            </div>
                            <div class="form-group">
                                <p>Event Type:</p>
                                <select id="type_modal" name="type_modal[]" id="type_modal" multiple="multiple">
                                    <?php while($single_type = mysqli_fetch_assoc($event_type_list)) { ?>
                                        <option value="<?php echo h($single_type['id']); ?>"><?php echo h($single_type['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" name="edit_event" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="add-event" tabindex="-1" role="dialog" aria-labelledby="add-event" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  action="" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title_modal" class="form-control" id="title_modal" aria-describedby="emailHelp" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea class="form-control" id="desc_modal" name="desc_modal" placeholder="Description" rows="5"></textarea>
                            </div>
                            <div class="form-group" style="display: none">
                                <input class="form-control" id="id_modal" name="id_modal" />
                            </div>
                            <div class="form-group">
                                <p>Event Type:</p>
                                <select id="type_modal" name="type_modal[]" id="type_modal" multiple="multiple">
                                    <?php while($single_type = mysqli_fetch_assoc($event_type_list)) { ?>
                                        <option value="<?php echo h($single_type['name']); ?>"><?php echo h($single_type['name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" name="add_event" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add-type" tabindex="-1" role="dialog" aria-labelledby="add-type" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form  action="" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Type name</label>
                                <input type="text" name="type_name_modal" class="form-control" id="type_name_modal" aria-describedby="emailHelp" placeholder="Enter type name">
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" name="add_type" class="btn btn-success">Add type</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $(function () {
            $('.view-btn').on('click', function (event) {
                const button = $(event.relatedTarget); /*Button that triggered the modal*/
                const id = $(this).attr("data-id");
                const title = $(this).attr("data-eventName");
                const desc = $(this).attr("data-desc");
                const typeNames = $(this).attr("data-typeName");
                const modal = $('#event-data');
                modal.find('#title_modal').val(title);
                modal.find('#desc_modal').val(desc);
                // modal.find('#type_modal').val(typeName);
                const data = [1, 2];
                console.log('TYPENAME', modal.find('#type_modal'))
                console.log('TYPENAME', $('#type_modal'))

                $('#type_modal').val(typeNames.split(',')).change();
                modal.find('#id_modal').val(id);
            });
        });
    });
    $(document).ready(function() {
        $('#type_modal').multiselect({
            includeSelectAllOption: true,
            onChange: function() {
                const selected = this.$select.val();
                console.log('selected', selected)
            }
        });
    });

</script>
<?php include(SHARED_PATH . '/footer.php'); ?>