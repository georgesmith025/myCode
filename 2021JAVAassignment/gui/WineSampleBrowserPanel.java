package uk.ac.sheffield.assignment2021.gui;

import java.awt.Component;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JButton;

import uk.ac.sheffield.assignment2021.codeprovided.gui.AbstractWineSampleBrowserPanel;
import uk.ac.sheffield.assignment2021.codeprovided.*;
import java.util.ArrayList;
import java.util.List;

public class WineSampleBrowserPanel extends AbstractWineSampleBrowserPanel {
    public WineSampleBrowserPanel(AbstractWineSampleCellar cellar) {
        super(cellar);
    }

    @Override
    public void addListeners() {
    	buttonAddFilter.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				addFilter();
			}			
		});
    	
    	buttonClearFilters.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				clearFilters();
			}			
		});
    	
    	comboWineTypes.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				executeQuery();
			}			
		});
    	
    	comboHistogramProperties.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				updateHistogram();
			}			
		});
	}

    @Override
    public void addFilter() {
    	try {
	    	WineProperty wineProperty = WineProperty.fromName((String)comboQueryProperties.getSelectedItem());
	    	String operator = (String) comboOperators.getSelectedItem();
	    	Double subQueryValue = Double.parseDouble(value.getText());
	    	
	    	SubQuery subQuery = new SubQuery(wineProperty, operator, subQueryValue);
	    	subQueryList.add(subQuery);
	    	subQueriesTextArea.setText(subQueryList.toString());
	    	
	    	executeQuery();
	    	
    	} catch (NumberFormatException e)	{
    		System.out.println("Make sure all filter boxes have a value before adding a filter");
    	}
    }

    @Override
    public void clearFilters() {
    	subQueryList.clear();
    	subQueriesTextArea.setText(null);
    	statisticsTextArea.setText(null);
    	filteredWineSamplesTextArea.setText(null);
    	
    	filteredWineSampleList = cellar.getWineSampleList(WineType.valueOf((String)comboWineTypes.getSelectedItem()));
    	updateWineDetailsBox();
    	updateHistogram();
    }

    @Override
    public void updateStatistics() {
    	filteredWineSampleList = this.getFilteredWineSampleList();
    	statisticsTextArea.setText(null);
    	
    	//Table titles
    	statisticsTextArea.append("	");
    	for (WineProperty wp : WineProperty.values()) { 
    		if (wp.toString().length() < 15)	{
    			statisticsTextArea.append(wp.toString() + "	");
    		} else {
    			statisticsTextArea.append(wp.toString().substring(0, 15) + "	");
    		}
		}
    	statisticsTextArea.append("\n");
    	
    	//Minimum value
    	statisticsTextArea.append("Minimum	");
    	for (WineProperty wp : WineProperty.values()) { 
    		double minVal = cellar.getMinimumValue(wp, filteredWineSampleList);
    		if (minVal == 10000) {
    			statisticsTextArea.append("0.0	");
    		} else {
        		statisticsTextArea.append(minVal + "	");
    		}
		}
    	statisticsTextArea.append("\n");
    	
    	//Maximum value
    	statisticsTextArea.append("Maximum	");
    	for (WineProperty wp : WineProperty.values()) {
    		double maxVal = cellar.getMaximumValue(wp, filteredWineSampleList);
    		if (maxVal == -1) {
    			statisticsTextArea.append("0.0	");
    		} else {
        		statisticsTextArea.append(maxVal + "	");
    		}
		}
    	statisticsTextArea.append("\n");
    	
    	//Average value
    	statisticsTextArea.append("Average	");
    	for (WineProperty wp : WineProperty.values()) { 
    		statisticsTextArea.append((double)((int)(cellar.getMeanAverageValue(wp, filteredWineSampleList)*10000))/10000 + "	");
		}
    	statisticsTextArea.append("\n");
    	
    	statisticsTextArea.append("Showing " + filteredWineSampleList.size() + " out of " + cellar.getNumberWineSamples(WineType.ALL) + " samples.");
    }

    @Override
    public void updateWineDetailsBox() {
    	filteredWineSampleList = this.getFilteredWineSampleList();
    	filteredWineSamplesTextArea.setText(null);
    	
    	//Table titles
    	filteredWineSamplesTextArea.append("Wine type" + "	");
    	filteredWineSamplesTextArea.append("ID" + "	");
    	for (WineProperty wp : WineProperty.values()) { 
    		if (wp.toString().length() < 15)	{
    			filteredWineSamplesTextArea.append(wp.toString() + "	");
    		} else {
    			filteredWineSamplesTextArea.append(wp.toString().substring(0, 15) + "	");
    		}
		}
    	filteredWineSamplesTextArea.append("\n");
    	
    	//Table content
    	for (WineSample ws : filteredWineSampleList) {
    		filteredWineSamplesTextArea.append(ws.getWineType() + "	");
        	filteredWineSamplesTextArea.append(ws.getId() + "	");
        	for (WineProperty wp : WineProperty.values()) { 
        		filteredWineSamplesTextArea.append((double)((int)(ws.getProperty(wp)*1000000))/1000000 + "	");
        	}
        	filteredWineSamplesTextArea.append("\n");
    	}
    	updateStatistics();
    }

    @Override
    public void executeQuery() {
    	Query currentQuery = new Query(subQueryList, WineType.valueOf((String)comboWineTypes.getSelectedItem()));
    	filteredWineSampleList = currentQuery.executeQuery(cellar);
    	updateWineDetailsBox();
    	updateHistogram();
    }
}
