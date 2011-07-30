
<div style="border-bottom:1px solid #ccc;">
    <h2> <?php echo htmlspecialchars($t->title);?> </h2>
    <p> Bounty &nbsp; <b> <?php echo htmlspecialchars($t->bounty);?> </b> (<?php echo htmlspecialchars($t->organizationName);?> , posted on <?php echo htmlspecialchars($t->createdOn);?>)
    <h3> Candidate dtails </h3>
    <p> Name: <?php echo htmlspecialchars($t->cvName);?> &nbsp; Email: <?php echo htmlspecialchars($t->cvEmail);?> &nbsp; Phone: <?php echo htmlspecialchars($t->cvPhone);?> </p>
    <p> Compnay: <?php echo htmlspecialchars($t->cvCompany);?> &nbsp; Education : <?php echo htmlspecialchars($t->cvEducation);?> &nbsp; Location : <?php echo htmlspecialchars($t->cvLocation);?> </p>
    <p> Skills: &nbsp; <?php echo htmlspecialchars($t->cvSkill);?> </p>
    <p> <?php echo htmlspecialchars($t->cvDescription);?> </p>
    

</div>