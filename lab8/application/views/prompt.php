<form action="/planner/display/" method="post">
    <h2>Ferry Travel Planner</h2>
    <br />
    
    <label>Leaving from</label>
    <select name="start" value="start">
    {ports}
        <option value="{port}" name="{name}" id="start">{name}</option>
    {/ports}
    </select>
    
    <br />
    <label>Destination </label>
    <select name="end" value="end">
        {ports2}
        <option value="{port}" name="{name}" id="end">{name}</option>
        {/ports2}
    </select>
    <br/>
    <br/>
    
    <input type="submit" value="Submit Changes"/>
</form>