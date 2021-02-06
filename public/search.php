<?php require_once('../private/initialize.php'); ?>
<?php $page_title = 'Search'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<?php

$logged_in = check_login_status();

function getTypes($typeString) {
    $typeArray = explode(',',$typeString);
    $intersectArray = array_unique($typeArray);
    return implode(',', $intersectArray);
}
if (isset($_POST['apply_event'])) {
    $id = $_POST['id_modal'];
    $result = apply_to_event($id);
}

if (isset($_GET['search'])) {
    $searchKeyword = $_GET['search_keyword'];
    $events = fetch_all_events($searchKeyword);
}

?>

<div class="contain">
<h2>Search result : <?php echo $_GET['search_keyword'] ?></h2>
<div class="standout-row">
    <?php while($event = mysqli_fetch_assoc($events)) { ?>
        <div class="card" style="width:400px">
            <img class="card-img-top" src="images/event.jpg" alt="Card image">
            <div class="card-body">
                <h4 class="card-title"><?php echo h($event['name']); ?></h4>
                <h6 class="card-title blue"><?php echo getTypes($event['types']); ?></h6>
                <p class="card-text"><?php echo substr(h($event['desc']), 0, 100); ?></p>
                <button
                    name="view-btn"
                    class="btn btn-primary view-btn"
                    data-toggle="modal"
                    data-target="#exampleModal"
                    data-desc="<?= $event['desc']; ?>"
                    data-id="<?= $event['id']; ?>"
                    data-typeName="<?= getTypes($event['types']); ?>"
                    data-eventName="<?= $event['name']; ?>"
                >View Event
                </button>
            </div>
        </div>
    <?php } ?>
</div>


