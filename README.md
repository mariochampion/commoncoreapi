# commoncoreapi repo

## (IN PROGRESS, as this is a re-do of a project which went offline...)

The users of Trails desired to tag their resources with standards from the Common Core, but there was no API-able mechanism to do so. Therefore, I scraped the open data*, built several middleware scripts to restructure it in a new database, built the API endpoints, then documented and made it all available under Creative Commons Attribution license.

Developers can utilize two REST APIs to search the Common Core standards by grade and/or keyword and/or component, with a JSON object result. 

There is Query API to search for summary information of matching standards, and the Detail API for extended information on one specific standard. Documentation includes the complete cycle of a query call, result, detail call and detail result.

## *data scraped from open source at http://www.achievementstandards.org/