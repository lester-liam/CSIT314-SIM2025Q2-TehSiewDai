<?php

require_once('Database.php');

class Report
{
    protected string $date;                 // Report Date
    protected string $category;             // Service Category
    protected string $numNewService;        // Number of New Services
    protected string $numUpdatedService;    // Number of Updated Services
    protected string $totalViews;           // Total View Count
    protected float $totalShortlists;       // Total Shortlist Count

    /**
     * Select Daily Report from DailyReportView
     * @return ?array Array of Daily Report Records
     */
    public function getDailyReport(): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $sql = "SELECT * FROM DailyReportView
                    ORDER BY date DESC, category;";
            $stmt = $db_conn->prepare($sql);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return array of objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Report');
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Select Weekly Report from DailyReportView
     * @return ?array Array of Weeky Report Records
     */
    public function getWeekyReport(): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $sql = "SELECT * FROM WeeklyReportView
                    ORDER BY
                    CASE
                        WHEN date IS NOT NULL THEN SUBSTRING(date, 1, 4) + 0
                        ELSE NULL
                    END DESC,
                    CASE
                        WHEN date IS NOT NULL THEN SUBSTRING(date, 7) + 0
                        ELSE NULL
                    END DESC, category;";
            $stmt = $db_conn->prepare($sql);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return array of objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Report');
            } else {
                return null;
            }

        } catch (PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Select Monthly Report from DailyReportView
     * @return ?array Array of Weeky Report Records
     */
    public function getMonthlyReport(): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $sql = "SELECT * FROM MonthlyReportView
                    ORDER BY date DESC, category;";
            $stmt = $db_conn->prepare($sql);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return array of objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Report');
            } else {
                return null;
            }

        } catch (PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    // Accessor Methods
    public function getDate(): string
    {
        return $this->date;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getNumNewService(): string
    {
        return $this->numNewService;
    }

    public function getNumUpdatedService(): string
    {
        return $this->numUpdatedService;
    }

    public function getTotalViews(): string
    {
        return $this->totalViews;
    }

    public function getTotalShortlists(): float
    {
        return $this->totalShortlists;
    }
}