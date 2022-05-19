import java.util.Random;

public class RunRamblersAStar {
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
		SearchState initialState = (SearchState) new RamblersState(start, 0, 0);
		    
		String resultAStar = searcher.runSearch(initialState, "AStar");
		System.out.println(resultAStar);
	 }
}