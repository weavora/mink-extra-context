<html>

<body>
<form action="form.php">

    <label for="text">Text</label>
    <input type="text" id="text" value="" >

    <hr />

    <label for="checkbox">Checkbox</label>
    <input type="checkbox" id="checkbox" value="1" >

    <hr />

    <label for="select">Select</label>
    <select id="select">
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
    </select>

    <hr />

    <label for="multiple_select">Multiple Select</label>
    <select id="multiple_select" multiple="multiple">
        <option value="1">MOption 1</option>
        <option value="2">MOption 2</option>
        <option value="3">MOption 3</option>
    </select>

    <hr />

    <label for="radio1">Radio 1</label>
    <input type="radio" id="radio1" value="1" name="radio" />
    <label for="radio2">Radio 2</label>
    <input type="radio" id="radio2" value="2" name="radio" />
    <label for="radio3">Radio 3</label>
    <input type="radio" id="radio3" value="3" name="radio" />

    <hr />

    <label for="textarea">Textarea</label>
    <textarea id="textarea"></textarea>

    <hr />

    <div>
        <label>Checkbox Group</label>
        <label for="checkbox1">Checkbox 1</label>
        <input type="checkbox" id="checkbox1" name="checkbox[]" value="1" >
        <label for="checkbox2">Checkbox 2</label>
        <input type="checkbox" id="checkbox2" name="checkbox[]" value="2" >
        <label for="checkbox3">Checkbox 3</label>
        <input type="checkbox" id="checkbox3" name="checkbox[]" value="3" >
    </div>

    <hr />

    <input type="submit" value="Save" />
</form>

</body>
</html>
