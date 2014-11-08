<h4>From {origin} to {destination}</h4>
<div class="{alerting}">
    {errormessages}
</div>
<table class="table">
    <tr>
        <th>Leaves</th>
        <th>Arrives</th>
        <th>Stops</th>
    </tr>
    {sailings}
    <tr>
        <td>{depart}</td>
        <td>{arrive}</td>
        <td>{stops}</td>
    </tr>
    {/sailings}
</table>


<a href="/planner" class="btn btn-large btn-primary">Next Trip</a>