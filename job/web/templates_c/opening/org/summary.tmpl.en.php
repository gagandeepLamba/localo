
<div class="summary" style="border-bottom:1px solid #ccc;">
   
    <h2>  <?php echo $t->title;?> </h2>
    <span> Posted by:&nbsp;<?php echo $t->createdBy;?> </span>
    <span> Organization:&nbsp;<?php echo $t->organizationName;?> </span>
    <span> Location:&nbsp;<?php echo $t->location;?> </span>
    <p> <?php echo $t->description;?> </p>
    <p> Skills:&nbsp;<?php echo $t->skill;?> </p>
    <p> Bounty:&nbsp;<?php echo $t->bounty;?> </p>

    <p> 
        <a href="/application/list.php?g_opening_id=<?php echo htmlspecialchars($t->uuid);?>"> View Applications </a>
        

    </p>

</div>