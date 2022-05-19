import java.util.*;

public class RamblersState extends SearchState {
	//The point of this state
	private Coords point;
	
	//Constructor
	//A* - current estRemCost
	public RamblersState(Coords pt, int lCost, int rCost) {
		point = pt;
		localCost = lCost;
		estRemCost = rCost;
	}
	
	//get methods
	public int getPointx() {
		return point.getx();
	}
	public int getPointy() {
		return point.gety();
	}
	
	@Override
	boolean goalPredicate(Search searcher) {
		RamblersSearch rSearcher = (RamblersSearch) searcher;
		int x = rSearcher.getGoalX();
		int y = rSearcher.getGoalY();
		if (x == point.getx() && y == point.gety())
			return true;
		return false;
	}
	
	public int euclid(int startX, int startY, Search searcher) {
		RamblersSearch rSearcher= (RamblersSearch) searcher;
		
		int x = rSearcher.getGoalX();
		int y = rSearcher.getGoalY();
		
		int ec = (startX-x) * (startX-x) + (startY-y) * (startY-y);
	    int euclidean = (int) Math.sqrt(ec);
	    
	    return euclidean;
	}
	
	public int manhattan(int startX, int startY, Search searcher) {
		RamblersSearch rSearcher= (RamblersSearch) searcher;
		
		int x = rSearcher.getGoalX();
		int y = rSearcher.getGoalY();
		
		int manhattan = Math.abs(startX-x) + Math.abs(startY-y);
		
		return manhattan;
	}
	
	@Override
	ArrayList<SearchState> getSuccessors(Search searcher) {
		RamblersSearch rSearcher = (RamblersSearch) searcher;
		TerrainMap terrainMap = rSearcher.getMap();
		int[][] terrainMapArray = terrainMap.getTmap();
		
		ArrayList<SearchState> successors = new ArrayList();
		int lCost = 0;
		int x = point.getx();
		int y = point.gety();
		int newX;
		int newY;
		
		//Comment/uncomment the same estimate method in each successor method to change the heuristic used
		
		//successor up
		if (y > 0 && y < terrainMap.getDepth()) {
			newX = x;
			newY = y - 1;
			
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			int estimate = euclid(newX,newY,rSearcher);
			//int estimate = manhattan(newX,newY,rSearcher);
			/*
			int goalX=rSearcher.getGoalX();
			int goalY=rSearcher.getGoalY();
			int estimate = Math.abs(terrainMapArray[newY][newX] - terrainMapArray[goalY][goalX]);
			*/
			successors.add(new RamblersState (new Coords(newY, newX), lCost, estimate));
		}
		
		//successor down
		if (y < terrainMap.getDepth() - 1) {
			newX = x;
			newY = y + 1;
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			int estimate = euclid(newX,newY,rSearcher);
			//int estimate = manhattan(newX,newY,rSearcher);
			/*
			int goalX=rSearcher.getGoalX();
			int goalY=rSearcher.getGoalY();
			int estimate = Math.abs(terrainMapArray[newY][newX] - terrainMapArray[goalY][goalX]);
			*/
			successors.add(new RamblersState (new Coords(newY, newX), lCost, estimate));
		}
		
		//successor left
		if (x > 0 && x < terrainMap.getWidth()) {
			newX = x - 1;
			newY = y;
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			int estimate = euclid(newX,newY,rSearcher);
			//int estimate = manhattan(newX,newY,rSearcher);
			/*
			int goalX=rSearcher.getGoalX();
			int goalY=rSearcher.getGoalY();
			int estimate = Math.abs(terrainMapArray[newY][newX] - terrainMapArray[goalY][goalX]);
			*/
			successors.add(new RamblersState (new Coords(newY, newX), lCost, estimate));
		}
		
		//successor right
		if (x < terrainMap.getWidth() - 1) {
			newX = x + 1;
			newY = y;
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			int estimate = euclid(newX,newY,rSearcher);
			//int estimate = manhattan(newX,newY,rSearcher);
			/*
			int goalX=rSearcher.getGoalX();
			int goalY=rSearcher.getGoalY();
			int estimate = Math.abs(terrainMapArray[newY][newX] - terrainMapArray[goalY][goalX]);
			*/
			successors.add(new RamblersState (new Coords(newY, newX), lCost, estimate));
		}
		
		return successors;
	}
	
	@Override
	boolean sameState(SearchState n2) {
		RamblersState n = (RamblersState) n2;
		if ((n.getPointx() == point.getx()) && (n.getPointy() == getPointy()))
			return true;
		return false;
	}
	
	public String toString() {
		return point.gety() + "," + point.getx();
	}
}