<select name="lang" onchange="setLanguage(this.value);" style="float: right; color: #000">
    <option value="en" <?php if($_SESSION[$lang]=="en"){ echo 'selected="selected"';}?>>English (eng)</option>
    <option value="fr" <?php if($_SESSION[$lang]=="fr"){ echo 'selected="selected"';}?>>Fran&#231;ais (fre)</option>
    <option value="lv" <?php if($_SESSION[$lang]=="lv"){ echo 'selected="selected"';}?>>Latvie&#353;u (lav)</option>
    <option value="nl" <?php if($_SESSION[$lang]=="nl"){ echo 'selected="selected"';}?>>Nederlands (dut)</option>
    <option value="pl" <?php if($_SESSION[$lang]=="pl"){ echo 'selected="selected"';}?>>Polski</option>
</select>