<div class="top-menu d-flex justify-content-around">
    <div>
        <form class="">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        </form>
    </div>
    <div class="icon">
        <ul class="d-flex">
            <li>
                <button type="button" class="btn position-relative">
                    <i class="fa-solid fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        9+
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>
            </li>
            <li>
                <button type="button" class="btn position-relative">
                    <i class="fa-regular fa-message"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        5+
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>
            </li>
            <li class="user"><i class="fa-solid fa-user"></i>Name</li>
        </ul>
    </div>
</div>

<div class="all-content">
    <?php 

    include_once("functions.php");

    if (isset($_GET['item'])) {
        $item = sanitize_url($_GET['item']);

        switch ($item) {
            case 'add-content':
                include_once("pages/add-content.php");
                break;
            // Add more cases if needed
            default:
                // Handle invalid item parameter
                break;
        }
    }
    ?>
</div>
