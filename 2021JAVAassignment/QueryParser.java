package uk.ac.sheffield.assignment2021;

import uk.ac.sheffield.assignment2021.codeprovided.*;

import java.util.ArrayList;
import java.util.List;

public class QueryParser extends AbstractQueryParser {
    @Override
    public List<Query> readQueries(List<String> queryTokens) throws IllegalArgumentException {
    	//Preparing and defining variables for a new query
    	ArrayList<Query> queryObjects = new ArrayList<>();
    	List<SubQuery> currentSubQueryList = new ArrayList<>();
    	WineType currentWineType = WineType.ALL;
    	Query currentQuery = null;
    	
    	for (int i = 0; i < queryTokens.size(); i++) {
    		//Checking for WineType. Red, White, or All
    		if (queryTokens.get(i).equals("red") && !(queryTokens.get(i+2).equals("white"))) {
    			currentWineType = WineType.RED;
    		} else if (queryTokens.get(i).equals("white") && !(queryTokens.get(i+2).equals("red"))) {
    			currentWineType = WineType.WHITE;
    		} else if ((queryTokens.get(i).equals("red") && (queryTokens.get(i+2).equals("white"))) 
    				|| (queryTokens.get(i).equals("white") && (queryTokens.get(i+2).equals("red")))) {
    			currentWineType = WineType.ALL;
    			i += 2;
    		
    		//Checking for trigger "where" or "and" to use the next 3 tokens to form a subQuery
    		} else if (queryTokens.get(i).equals("where") || (queryTokens.get(i).equals("and"))) {
    			//Using discovered queryTokens to form a subQuery and add it to the current subQuery list
    			WineProperty currentWineProperty = WineProperty.fromFileIdentifier(queryTokens.get(i+1));
    			SubQuery currentSubQuery = new SubQuery(
    					currentWineProperty
    					, queryTokens.get(i+2)
    					, Double.parseDouble(queryTokens.get(i+3))
    					);
    			currentSubQueryList.add(currentSubQuery);
    		
    		//Checking for the end of the current set of queryTokens or the end of the queryTokens list
    		//Making a Query with the currentSubQueryList and adding it to the list of Queries
    		} else if (i < queryTokens.size() - 1) {
    			if (queryTokens.get(i+1).equals("select")) {
    				currentQuery = new Query(currentSubQueryList, currentWineType);
    				queryObjects.add(currentQuery);
    				currentSubQueryList = new ArrayList<>();
    			}
    		} else if (i == queryTokens.size() - 1) {
    			currentQuery = new Query(currentSubQueryList, currentWineType);
				queryObjects.add(currentQuery);
				currentSubQueryList = new ArrayList<>();
    		}
    	}
        return queryObjects;
    }
}
