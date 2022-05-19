import java.util.*;

public class RamblersState extends SearchState {
	//The point of this state
	private Coords point;
	
	//Constructor
	//A* - current estRemCost
	public RamblersState(Coords pt, int lCost) {
		point = pt;
		localCost = lCost;
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
		RamblersSearch rsearcher = (RamblersSearch) searcher;
		int x = rsearcher.getGoalX();
		int y = rsearcher.getGoalY();
		if (x == point.getx() && y == point.gety())
			return true;
		return false;
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
		
		//successor up
		if (y > 0 && y < terrainMap.getDepth()) {
			newX = x;
			newY = y - 1;
			
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			successors.add(new RamblersState (new Coords(newY, newX), lCost));
		}
		
		//successor down
		if (y < terrainMap.getDepth() - 1) {
			newX = x;
			newY = y + 1;
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			successors.add(new RamblersState (new Coords(newY, newX), lCost));
		}
		
		//successor left
		if (x > 0 && x < terrainMap.getWidth()) {
			newX = x - 1;
			newY = y;
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			successors.add(new RamblersState (new Coords(newY, newX), lCost));
		}
		
		//successor right
		if (x < terrainMap.getWidth() - 1) {
			newX = x + 1;
			newY = y;
			if (terrainMapArray[newY][newX] > terrainMapArray[y][x])
				lCost = 1 + Math.abs(terrainMapArray[newY][newX] - terrainMapArray[y][x]);
			else
				lCost = 1;
			
			successors.add(new RamblersState (new Coords(newY, newX), lCost));
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