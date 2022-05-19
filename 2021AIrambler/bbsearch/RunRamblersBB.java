import java.util.*;
import java.util.Random;

public class RunRamblersBB {

	public static void main(String[] arg) {
		  
		TerrainMap terrainMap = new TerrainMap("tmc.pgm");
		
		Random rand = new Random();
		int randomX = rand.nextInt(terrainMap.getWidth());
		int randomY = rand.nextInt(terrainMap.getDepth());
		Coords start = new Coords(randomX, randomY);
			    
		randomX = rand.nextInt(terrainMap.getWidth());
		randomY = rand.nextInt(terrainMap.getDepth());
		Coords goal = new Coords(randomX, randomY);
				
		RamblersSearch searcher = new RamblersSearch(terrainMap,goal);
		SearchState initialState = (SearchState) new RamblersState(start, 0);
			    
		String resultBB = searcher.runSearch(initialState, "branchAndBound");
		System.out.println(resultBB);
	}
}