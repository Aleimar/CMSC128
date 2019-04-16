<?Php
$host_name = "localhost";
$database = "id5312484_mtci_davao"; // Change your database nae
$username = "id5312484_megatesting"; // Your database user id 
$password = "cmsc128ily";          // Your password

//////// Do not Edit below /////////
try {
$dbo = new PDO('mysql:host='.$host_name.';dbname='.$database, $username, $password);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
?>