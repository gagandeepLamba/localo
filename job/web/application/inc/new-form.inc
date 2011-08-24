

<p class="help-text">
    Please fill in the details below and click Save. You can attach documents on the next screen.

</p>

<div id="form-wrapper">
    <form id="web-form1" class="web-form" name="web-form1" action="/application/post/new.php" enctype="multipart/form-data"  method="POST">

        <div class="error">    </div>

        <table class="form-table">
            <tr>
                <td class="field"> Name<span class="red-label">*</span></td>
                <td>
                    <input type="text" name="cv_name" maxlength="128" class="required" title="&gt;&nbsp;Name is a required field" value="<?php echo $sticky->get('cv_name'); ?> "/>
                </td>
            </tr>

            <tr>
                <td class="field"> Email<span class="red-label">*</span></td>
                <td>
                    <input type="text" name="cv_email" maxlength="128" class="required" title="&gt;&nbsp;Email is a required field" value="<?php echo $sticky->get('cv_email'); ?>"/>
                </td>
            </tr>

            <tr>
                <td class="field"> Phone<span class="red-label">*</span></td>
                <td>
                    <input type="text" name="cv_phone" maxlength="16" class="required" title="&gt;&nbsp;Phone is a required field" value="<?php echo $sticky->get('cv_phone'); ?>"/>
                </td>
            </tr>

            <tr>
                <td class="field"> Education<span class="red-label">*</span></td>
                <td>
                    <input type="text" name="cv_education" maxlength="128" class="required" title="&gt;&nbsp;Phone is a required field" value="<?php echo $sticky->get('cv_education'); ?>"/>
                </td>
            </tr>

            <tr>
                <td class="field">Title (blank for freshers)</td>
                <td>
                    <input type="text" name="cv_title" maxlength="128" value="<?php echo $sticky->get('cv_title'); ?>"/>
                </td>
            </tr>

            <tr>
                <td class="field"> Company</td>
                <td>
                    <input type="text" name="cv_company" maxlength="128" value="<?php echo $sticky->get('cv_company'); ?>"/>
                </td>
            </tr>

            <!-- location - fill in with  candidate location -->
            <tr>
                <td class="field"> Location<span class="red-label">*</span></td>
                <td>
                    <input type="text" name="cv_location" maxlength="32" class="required" title="&gt;&nbsp;Location is a required field" value="<?php echo $sticky->get('cv_location', 'Bangalore'); ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span> Skills </span> <br>
                    <textarea  name="cv_skill" class="height-1 width-2" cols="50" rows="4" ><?php echo $sticky->get('cv_skill'); ?></textarea>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <span> Description (why you recommend this candidate) </span> <br>
                    <textarea  name="cv_description" class="width-2" cols="50" rows="10" ><?php echo $sticky->get('cv_description'); ?></textarea>
                </td>
            </tr>

        </table>


        <div class="button-container">
            <button type="submit" name="save" value="Save" onclick="this.setAttribute('value','Save');" ><span>Save</span></button>
            <a href="<?php echo $previousUrl; ?>">
                <button type="button" name="cancel"><span>Cancel</span></button>
            </a>
        </div>


        <!-- hidden fields -->
        <input type="hidden" name="organization_id" value="<?php echo $organizationId; ?>" />
        <input type="hidden" name="forwarder_email" value="<?php echo $userVO->email; ?>" />
        <input type="hidden" name="user_id" value="<?php echo $userVO->uuid; ?>" />
        <input type="hidden" name="opening_id" value="<?php echo $openingId; ?>" />

        <div style="clear: both;"></div>

    </form>
</div> <!-- form wrapper -->
