<?php
function update_company_details($name,$address, $telephone, $fax,$logo,$email, $website, $branches)
{
    include 'conf/config.php';
    include 'conf/opendb.php';

    $query = "UPDATE company_details SET
    name='$name',
    email='$email',
    tel='$telephone',
    address='$address',
    website='$website',
    fax='$fax',
    image='$logo',
    branches='$branches'
    WHERE id='1'";

    mysqli_query($conn, $query);

    include 'conf/closedb.php';
}

function get_company_details_info() {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query($conn, "SELECT * FROM company_details WHERE id='1'");
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        return $row;
    }
    include 'conf/closedb.php';
}
