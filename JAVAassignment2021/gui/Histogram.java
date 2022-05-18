package uk.ac.sheffield.assignment2021.gui;

import uk.ac.sheffield.assignment2021.codeprovided.AbstractWineSampleCellar;
import uk.ac.sheffield.assignment2021.codeprovided.WineProperty;
import uk.ac.sheffield.assignment2021.codeprovided.WineSample;
import uk.ac.sheffield.assignment2021.codeprovided.gui.AbstractHistogram;
import uk.ac.sheffield.assignment2021.codeprovided.gui.HistogramBin;

import java.util.List;
import java.util.ArrayList;
import java.util.NoSuchElementException;

public class Histogram extends AbstractHistogram {
    /**
     * Constructor. Called by AbstractWineSampleBrowserPanel
     *
     * @param cellar              to allow for getting min / max / avg values
     * @param filteredWineSamples a List of WineSamples to generate a histogram for.
     *                            These have already been filtered by the GUI's queries.
     * @param property            the WineProperty to generate a histogram for.
     */
    public Histogram(AbstractWineSampleCellar cellar, List<WineSample> filteredWineSamples, WineProperty property)
    {
        super(cellar, filteredWineSamples, property);
    }

    @Override
    public void updateHistogramContents(WineProperty property, List<WineSample> filteredWineSamples) {
    	//Preparing and defining variables 
    	wineCountsPerBin.clear();
    	ArrayList<Double> listOfValues = new ArrayList<>();
    	for (WineSample ws : filteredWineSamples) {
    		listOfValues.add(ws.getProperty(property));
    	}
    	this.property = property;
    	minPropertyValue = cellar.getMinimumValue(property, filteredWineSamples);
    	maxPropertyValue = cellar.getMaximumValue(property, filteredWineSamples);
    	double classInterval = (maxPropertyValue-minPropertyValue) / NUMBER_BINS;
    	
    	if (!(filteredWineSamples.isEmpty())) {
    		//If all values in the list are the same
	    	if (minPropertyValue == maxPropertyValue) {
	    		HistogramBin histogramBin = new HistogramBin(minPropertyValue, maxPropertyValue, true);
	    		wineCountsPerBin.put(histogramBin, listOfValues.size());
	    	
	    	//Make NUMBER_BINS amount of bins
	    	} else {
	    		for (int i=0; i < NUMBER_BINS; i++) {
	    	    	//Creating the current histogram bin with boundaries set by a class interval increasing with each loop
	    			boolean finalBin = false;
	    	    	if (i == NUMBER_BINS-1)
	    	    		finalBin = true;
	    	    	HistogramBin histogramBin = new HistogramBin(
	    	    			minPropertyValue+i*classInterval
	    	    			, minPropertyValue+(i+1)*classInterval
	    	    			, finalBin
	    	    			);
	    	    	
	    	    	//Counting how many values are within the boundaries of this bin
	    	    	int count = 0;
	    	    	for (double v : listOfValues) {
	    	    		if (histogramBin.valueInBin(v))
	    	    			count += 1;
	    	    	}
	    	    	wineCountsPerBin.put(histogramBin, count);
	    	    }
	    	}
    	}
    }

    @Override
    public double getAveragePropertyValue() throws NoSuchElementException {
    	return cellar.getMeanAverageValue(property, filteredWineSamples);
    }
}
