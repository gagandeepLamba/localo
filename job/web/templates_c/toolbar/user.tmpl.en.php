
 <div style="border:1px solid red;padding:20px;">
            <div>
                Hello, &nbsp;<?php echo htmlspecialchars($t->firstName);?> <?php echo htmlspecialchars($t->lastName);?> &nbsp; (<?php echo htmlspecialchars($t->email);?>)&nbsp; <a href="/logout.php"> logout </a>
                &nbsp; &nbsp;
                <a href="/user/applications.php"> my applications </a>

            </div>

        </div>