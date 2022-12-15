<h1>Wiki page</h1>

<div id="content">

</div>

<script>
var reader = new commonmark.Parser();
var writer = new commonmark.HtmlRenderer();
var parsed = reader.parse(`# [vrpUnits] 
List all units on a single page sorted by unit name ascending. This short code accepts **sort** and **order** properties.  The units can be sorted by any property attached to units in either **ASC** or **DESC** order. Only one sort and order key can be used at a time.

Examples: 

* \`[vrpUnits sort="Name" order="DESC"]\`
* \`[vrpUnits sort="City" order="ASC"]\`
* \`[vrpUnits sort="Bedrooms" order="ASC"]\`
* \`[vrpUnits sort="Sleeps" order="ASC"]\`

# \`[vrpSearch]\`
Displays all units that meet the search criteria passed via the shortcode attributes.  
Any combination of the following attributes may be used to generate the resulting list of units:  
\`* city\`  
\`* state\`  
\`* country\`  
\`* sleeps\`  
\`* max_adults\`  
\`* postal_code\`  
\`* province\`  
\`* bedrooms\`  
\`* bathrooms\`  
    \`* Bathrooms may be an integer (ex: bathrooms="5") to show units with 5 bathrooms.\`
    \`* Bathrooms may be a range (ex: bathrooms="5-6") to show units with 5 to 6 bathrooms.\`
\`* type\`
\`* area\`
\`* view\`
\`* location\`

All search attributes filter down data which means every attribute must match for a unit to show up in the result.  The following are attributes that can be used with comma delimited values to allow more than one match type for each of the following:  
\`* ids\`
\`* slugs\`
\`* types\`

Fuzzy Search for Unit Names and Types
* **namelike** Fuzzy match to unit names.
* **typelike** Fuzzy match to unit types.

## Example ##
The following is an example that would display all your units with three bedrooms located in Denver, Colorado: \`[vrpSearch bedrooms="3" city="Denver" state="CO"]\`

## Fuzzy Unit Name Search ##
The following is an exmaple that would display all units whose name begins with "SnowRidge".  If you have units named "SnowRidge 117" and "SnowRidge Queen" they would both show up in the result set using this short code.
\`[vrpSearch namelike="SnowRidge"]\`  

## Displaying multiple unit types ##
The following is an example that would display all your units in Colorado that match any of the following types: condo, villa, home.  \`[vrpSearch types="condo,villa,home" state="CO"]\`

## Displaying multiple (specific) units by Page Slug ##
Page slugs are customizable names that translate to the last element on the permalink to any given unit.  If your unit page is http://www.example.com/vrp/unit/hidden_hideaway_cabin then the unit's page slug is hidden_hideaway_cabin.  This value can be set in the admin panel @ gueststream.net

The following is an example that would display all your units with the following page slugs: "Winter_Wonderful", "Beach_Dayz", "hidden_hideaway_cabin" 
\`[vrpSearch slugs="Winter_Wonderful,Beach_Dayz,hidden_hideaway_cabin"]\`

## Sorting / Ordering Results ##
To sort the results by a specific field use the sort attribute and to order the results by ascending or descending use the order attribute with the value of low for ascending and high for descending.

\`[vrpSearch sort="Name" order="low" city="Denver" state="CO"]\` 
Will display all units in Denver, Colorado and sort them by the unit name in ascending order.

\`[vrpSearch sort="City" order="high" state="CO"]\` 
Will display all units in Colorado and sort them by City name descending.

## Excluding Results ##
You can optionally use an exclamation point before a value to denote "NOT".  The following is an example that would display all units with three bedrooms located in Colorado but NOT in Denver

\`[vrpSearch bedrooms="3" city="!Denver" state="CO"]\`

# [vrpComplexes]
Displays a list of all Complexes.  The sort order of and information displayed about complexes is managed in your Gueststream.net control panel.

# [vrpSearchForm]
Displays the simple search form for searching units based on availability.

# [vrpAdvancedSearchForm]
Displays the advanced search form for searching units based on availability plus all other criteria as enabled in your Gueststream.net control panel.

# [vrpCompare]
Displays the unit comparison page to guests that have selected/saved units to compare. This is sometimes called 'favorites' or 'saved' results.

# [vrpSpecials]
Displays all available rental specials.

# [vrpFeaturedUnit]
Displays one or more links to featured unit pages. This short code can be used with or without additional attributes.  The Featured unit theme file is vrpFeaturedUnit.php for displaying a single featured unit link and vrpFeaturedUnits.php for displaying multiple featured unit links.

* \`[vrpFeaturedUnit]\` will display a single (random) featured unit link.
* \`[vrpFeaturedUnit show=5]\` Will display up to 5 (random) featured unit links.
* \`[vrpFeaturedUnit field="City" value="Vail"]\` Will display 1 featured unit link wherein the Unit is in the City of Vail.
* \`[vrpFeaturedUnit field="View" value="Ocean Front" show=5]\` Will display up to 5 featured unit links that have an Ocean Front View.

# [vrpUnit page_slug="unit_page_slug"]
Turn any Post or Page in to a property page. This short code makes use of the unit.php template file, which is the same used for displaying the unit pages. Copy the page slug of the unit you would like to display from within the VRP by clicking edit on the unit in the unit list and navigating to the SEO tab.  Paste the page slug as the value to the page_slug attribute in this short code and publish.
![Unit Page Slug](http://www.gueststream.com/wp-content/uploads/2016/11/unit_page_slug.png)`); // parsed is a \'Node\' tree
// transform parsed if you like...
var result = writer.render(parsed); // result is a String

jQuery("#content").html(result);
</script>