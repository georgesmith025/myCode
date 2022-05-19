public class RamblersSearch extends Search{
	//Map to search through
	private TerrainMap map;
	//Goal point
	private Coords goal;
	
	public TerrainMap getMap() {
		return map;
	}
	
	public int getGoalX() {
		return goal.getx();
	}
	
	public int getGoalY() {
		return goal.gety();
	}
	
	public RamblersSearch(TerrainMap m, Coords g) {
		map = m;
		goal = g;
	}
}
