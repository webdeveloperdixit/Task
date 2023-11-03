<?php
/**
 * Class TableCreator
 *
 * This class creates and populates a table 'Test' and provides a method to select data from it.
 *
 * @final
 */
final class TableCreator
{
    private $db;

    /**
     * Constructor that creates the 'Test' table and fills it with random data.
     */
    public function __construct()
    {
        // Initialize the database connection (you should replace these with your actual database credentials)
        $this->db = new mysqli('localhost', 'root', 'Test@123', 'task');

        // Check if the connection was successful
        if ($this->db->connect_error) {
            die("Database connection failed: " . $this->db->connect_error);
        }

        // Create the 'Test' table
        $this->create();

        // Fill the 'Test' table with random data
        $this->fill();
    }

    private function create()
    {
        $sql = "CREATE TABLE IF NOT EXISTS Test (
            id INT AUTO_INCREMENT PRIMARY KEY,
            script_name VARCHAR(25),
            start_time DATETIME,
            end_time DATETIME,
            result ENUM('normal', 'illegal', 'failed', 'success')
        )";

        $this->db->query($sql);
    }

    private function fill()
    {
        // You can use any method to generate random data. For simplicity, we use placeholders here.
        $stmt = $this->db->prepare("INSERT INTO Test (script_name, start_time, end_time, result) VALUES (?, ?, ?, ?)");

        $scriptNames = ['Script A', 'Script B', 'Script C', 'Script D', 'Script E'];
        $results = ['normal', 'illegal', 'failed', 'success'];

        for ($i = 0; $i < 10; $i++) {
            $scriptName = $scriptNames[array_rand($scriptNames)];
            $startTime = date('Y-m-d H:i:s', rand(strtotime('-1 week'), time()));
            $endTime = date('Y-m-d H:i:s', rand(time(), strtotime('+1 day')));
            $result = $results[array_rand($results)];

            $stmt->bind_param("ssss", $scriptName, $startTime, $endTime, $result);
            $stmt->execute();
        }
    }

    public function get($criterion)
    {
        $criterion = $this->db->real_escape_string($criterion);

        $sql = "SELECT * FROM Test WHERE result IN ('$criterion')";
        $result = $this->db->query($sql);

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}
