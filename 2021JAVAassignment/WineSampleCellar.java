package uk.ac.sheffield.assignment2021;

import uk.ac.sheffield.assignment2021.codeprovided.*;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.NoSuchElementException;

public class WineSampleCellar extends AbstractWineSampleCellar {
    /**
     * Constructor - reads wine sample datasets and list of queries from text file,
     * and initialises the wineSampleRacks Map
     *
     * @param redWineFilename
     * @param whiteWineFilename
     */
    public WineSampleCellar(String redWineFilename, String whiteWineFilename) {
        super(redWineFilename, whiteWineFilename);
    }

    @Override
    public WinePropertyMap parseWineFileLine(String line) throws IllegalArgumentException {
	    String[] arrOfLine = line.split(";");
	    if (arrOfLine.length % 12 != 0)
			throw new IllegalArgumentException("Incorrect number of values");
		else {
			int count = 0;
		   	WinePropertyMap returnWinePropertyMap = new WinePropertyMap();
		   	for (WineProperty currentWP : WineProperty.values()) {
		   	    returnWinePropertyMap.put(currentWP, Double.parseDouble(arrOfLine[count]));
		   	    count += 1;
		   	}
		    return returnWinePropertyMap;
		}
    }

    @Override
    public void updateCellar() {
    	ArrayList<WineSample> allWineList = new ArrayList<>();
    	ArrayList<WineSample> redWineList = (ArrayList<WineSample>) getWineSampleList(WineType.RED);
    	ArrayList<WineSample> whiteWineLine = (ArrayList<WineSample>) getWineSampleList(WineType.WHITE);
    	
    	allWineList.addAll(redWineList);
    	allWineList.addAll(whiteWineLine);
    	
        wineSampleRacks.put(WineType.ALL, allWineList);
    }

    @Override
    public double getMinimumValue(WineProperty wineProperty, List<WineSample> wineList)
            throws NoSuchElementException {
        double minimumValue = 10000;
    	for (WineSample currentWineSample : wineList) {
    		double currentValue = (double) currentWineSample.getProperty(wineProperty);
    		if (currentValue < minimumValue)	{
    			minimumValue = currentValue;
    		}
    	}
        return minimumValue;
    }

    @Override
    public double getMaximumValue(WineProperty wineProperty, List<WineSample> wineList)
            throws NoSuchElementException {
    	double maximumValue = -1;
    	for (WineSample currentWineSample : wineList) {
    		double currentValue = (double) currentWineSample.getProperty(wineProperty);
    		if (currentValue > maximumValue)	{
    			maximumValue = currentValue;
    		}
    	}
        return maximumValue;
    }

    @Override
    public double getMeanAverageValue(WineProperty wineProperty, List<WineSample> wineList)
            throws NoSuchElementException {
    	double totalValue = 0;
    	double count = 0;
    	for (WineSample currentWineSample : wineList) {
    		double currentValue = (double) currentWineSample.getProperty(wineProperty);
    		totalValue += currentValue;
    		count += 1;
    	}
        return totalValue/count;
    }

    @Override
    public List<WineSample> getFirstFiveWines(WineType type) {
    	ArrayList<WineSample> wineList = (ArrayList<WineSample>) getWineSampleList(type);
    	ArrayList<WineSample> topFiveList = new ArrayList<>();
    	
    	for (int i = 0; i < 5; i++) {
    		topFiveList.add(wineList.get(i));
    	}
    	
        return topFiveList;
    }
}
