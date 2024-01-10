<?php
require_once '../../Connections/conn.php';

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

mysql_select_db($database_conn, $conn);
$colname_docs = "-1";
if (isset($_GET['id'])) {
    $colname_docs = $_GET['id'];
    $query_docs = sprintf("SELECT * FROM assets WHERE `id` = %s", GetSQLValueString($colname_docs, "int"));
}
$docs = mysql_query($query_docs, $conn) or die(mysql_error());
$row_docs = mysql_fetch_assoc($docs);
$totalRows_docs = mysql_num_rows($docs);

include '../include/header.php';
?>

<h1>المكتبة</h1>
<hr />

<?php do {?>
    
    <div class="media vw-50">
          <a class="d-flex align-self-center" href="#">
              <img class="img-fluid rounded-3" src="<?php echo "../../assets/images/uploads/" . $row_docs['src']; ?>" alt="<?php echo $row_rooms['img']; ?>" width="50px" height="50px">
          </a>
        </div>
    <tr>
      <td><?php echo $row_docs['id']; ?></td>
      <td><?php echo $row_docs['subject']; ?></td>
      <td><?php echo $row_docs['class']; ?></td>
      <td><?php echo $row_docs['asset']; ?></td>
      <td><?php echo $row_docs['src']; ?></td>
      <td><?php echo $row_docs['created']; ?></td>
      <td><?php echo $row_docs['updated']; ?></td>

    </tr>
    <?php } while ($row_docs = mysql_fetch_assoc($docs));
?>

<?php
mysql_free_result($docs);
include '../include/footer.php';
?>