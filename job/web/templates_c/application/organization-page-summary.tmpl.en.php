
<div style="border-bottom:1px solid #ccc;">
    <p> Name: <?php echo htmlspecialchars($t->cvName);?> &nbsp; Email: <?php echo htmlspecialchars($t->cvEmail);?> &nbsp; Phone: <?php echo htmlspecialchars($t->cvPhone);?> </p>
    <p> Compnay: <?php echo htmlspecialchars($t->cvCompany);?> &nbsp; Education : <?php echo htmlspecialchars($t->cvEducation);?> &nbsp; Location : <?php echo htmlspecialchars($t->cvLocation);?> </p>
    <p> Skills: &nbsp; <?php echo htmlspecialchars($t->cvSkill);?> </p>
    <p> <?php echo htmlspecialchars($t->cvDescription);?> </p>
    <p> forwarded by: &nbsp; <?php echo htmlspecialchars($t->forwarderEmail);?>
    <p>
        <a href="#"> Approve </a>
        &nbsp;|&nbsp;
        <a href="#"> Reject </a>
    </p>

</div>