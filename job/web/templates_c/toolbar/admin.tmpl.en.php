
 <div style="border:1px solid red;padding:20px;">
            <div>
                Hello <?php echo htmlspecialchars($t->company);?> administrator &nbsp;<?php echo htmlspecialchars($t->firstName);?> <?php echo htmlspecialchars($t->lastName);?> &nbsp; (<?php echo htmlspecialchars($t->email);?>)&nbsp; <a href="/logout.php"> logout </a>
            </div>

        </div>