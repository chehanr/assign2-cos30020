<nav class="pagination">
    <ul>
        <?php
            if(array_key_exists(($pageNumber - 1), $pagedArray)){
                $prevPage = $pageNumber - 1;
                echo "
                    <li class=\"page-item\">
                        <a class=\"page-link\" href=\"?page={$prevPage}\" tabindex=\"-1\">Previous</a>
                    </li>
                ";
            }
        ?>
        <?php
            if(array_key_exists(($pageNumber + 1), $pagedArray)){
                $nextPage = $pageNumber + 1;
                echo "
                    <li class=\"page-item\">
                        <a class=\"page-link\" href=\"?page={$nextPage}\">Next</a>
                    </li>
                ";
            }
        ?>
    </ul>
</nav>