<?php
  session_start();
  require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/configProjSurvey.php';
  require_once($_SERVER["DOCUMENT_ROOT"] . "/../Support/basicLib.php");


// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="ProjectSurvey.csv"');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Entered By', 'Entered On', 'Record_ID', 'Dept', 'Dept_Contact', 'ProjectSite Name', 'Role', 'URL', 'Blog', 'ChatRoom', 'Communication', 'Coursework', 'File Sharing', 'File Storage', 'Informational', 'Other Usage', 'Usage Comments', 'Type', 'Assitance Comments'));

if ($login_name === "ahlgrenl" || $login_name === "mdbacon" || $login_name === "rsmoke") {
            $sqlSelect = <<<SQL
                SELECT
                    editedby,
                    editedon,
                    id,
                    dept,
                    deptContactUniqname,
                    projSiteName,
                    projSiteRole,
                    projSiteURL,
                    blog,
                    chatroom,
                    communications,
                    coursework,
                    filesharing,
                    filestorage,
                    informational,
                    otherusage,
                    howusedcomments,
                    projType,
                    assistcomments
                FROM  tbl_surveylist
                ORDER BY dept, deptContactUniqname ASC
SQL;

}
if (!$result = $db->query($sqlSelect)) {
            db_fatal_error("data select issue", $db->error);
            exit;
}

// loop over the rows, outputting them
while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
}