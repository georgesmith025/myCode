package uk.ac.sheffield.assignment2021.gui;

import java.awt.*;
import java.awt.font.*;
import java.awt.geom.*;
import java.util.Map;
import java.util.List;

import uk.ac.sheffield.assignment2021.codeprovided.gui.AbstractHistogram;
import uk.ac.sheffield.assignment2021.codeprovided.gui.AbstractHistogramPanel;
import uk.ac.sheffield.assignment2021.codeprovided.gui.AbstractWineSampleBrowserPanel;
import uk.ac.sheffield.assignment2021.codeprovided.gui.HistogramBin;

public class HistogramPanel extends AbstractHistogramPanel
{
    public HistogramPanel(AbstractWineSampleBrowserPanel parentPanel, AbstractHistogram histogram)
    {
        super(parentPanel, histogram);
    }

    @Override
    protected void paintComponent(Graphics g) {
    	//Preparing and defining variables by fetching values from other classes
    	Map<HistogramBin, Integer> wineCountsPerBin = this.getHistogram().getWineCountsPerBin();
    	List<HistogramBin> histogramBinList = this.getHistogram().getBinsInBoundaryOrder();
    	double maxPropertyValue = this.getHistogram().getMaxPropertyValue();
    	double minPropertyValue = this.getHistogram().getMinPropertyValue();
    	double averagePropertyValue = this.getHistogram().getAveragePropertyValue();
    	double total = this.getHistogram().largestBinCount();
    	
    	//Painting and refreshing the histogram
    	super.repaint();
    	super.paintComponent(g);
    	
    	//Preparing and defining the gui based variables
        Dimension d = getSize();
        Graphics2D g2 = (Graphics2D) g;
        //width and height of the graph, not the panel it's in
        double maxWidth = d.width - d.width/10;
        double maxHeight = d.height - d.height/8;
        //width of a bar in the histogram
        double width = maxWidth / wineCountsPerBin.size();
        //text based variables
        FontRenderContext frc = g2.getFontRenderContext();
        Font xlabels = new Font("Courier", Font.BOLD, 10);
        Font labels = new Font("Courier", Font.BOLD, 12);
        Font titles = new Font("Courier", Font.BOLD, 16);
        
        //Loop for each bar in the histogram
        for (int i=0; i < histogramBinList.size(); i++) {
        	//height of a bar in the histogram
        	double height = (maxHeight) * (((wineCountsPerBin.get(histogramBinList.get(i))))/total);
        	
        	//Blue bar drawn
            g2.setPaint(new Color(173, 216, 230));
            Rectangle2D r = new Rectangle2D.Double(i*width + d.width/10,maxHeight-height,width, height);
            g2.draw(r);
            g2.fill(r);
            g2.setPaint(new Color(0, 0, 0));
        }
        
        //x axis
        Line2D xAxisLine = new Line2D.Double(d.width/10, maxHeight, maxWidth + d.width/10, maxHeight);
        g2.draw(xAxisLine);
        
        for (int i=0; i < wineCountsPerBin.size(); i++)	{
        	//Current tick mark on the x axis
        	Line2D xAxisTick = new Line2D.Double(
        			d.width/10 + i*width, 
        			maxHeight, 
        			d.width/10 + i*width, 
        			maxHeight+maxHeight/15
        			);
            g2.draw(xAxisTick);
            
            //Variables for the boundary the current bin's values fit into
            double classInterval = (maxPropertyValue - minPropertyValue) / (double)wineCountsPerBin.size();
            double lowerBoundary = (double)((int)((minPropertyValue+classInterval*i)*1000))/1000;
            double upperBoundary = (double)((int)((minPropertyValue+classInterval*(i+1))*1000))/1000;
            
            //Displaying the boundary the current bin's values fit into as x axis labels
            String xLabel;
            if (lowerBoundary == upperBoundary) {
            	xLabel = (i+1) + ")" + lowerBoundary;
            } else {
            	xLabel = (i+1) + ")" + lowerBoundary + "<=" + upperBoundary;
            }
            TextLayout tl = new TextLayout(xLabel, xlabels, frc);
            tl.draw(g2, (int)(d.width/10 + width*i + 5), (int)(maxHeight+maxHeight/20) + 3);
        }
        //x axis title
        String xTitle = "Class intervals";
        TextLayout xtl = new TextLayout(xTitle, titles, frc);
        xtl.draw(g2, (int)(d.width/2), (int)(maxHeight+maxHeight/7));
        
        
        //y axis
        Line2D yAxisLine = new Line2D.Double(d.width/10, maxHeight, d.width/10, 0);
        g2.draw(yAxisLine);
        
        for (int i=0; i <= 4; i++)	{
        	//Current tick mark on the y axis
        	Line2D yAxisTick = new Line2D.Double(
        			d.width/10 - d.width/25, 
        			maxHeight-(i*maxHeight/4), 
        			d.width, 
        			maxHeight-(i*maxHeight/4)
        			);
            g2.draw(yAxisTick);
            
            //Showing the amount of values represented by the current horizontal line
            String yLabel = String.valueOf((total/4)*i);
            TextLayout tl = new TextLayout(yLabel, labels, frc);
            tl.draw(g2, (int)(d.width/10 - d.width/25), (int)(maxHeight-(i*maxHeight/4) + maxHeight/18));
        }
      //y axis title
        String yTitle = "Frequency";
        TextLayout ytl = new TextLayout(yTitle, titles, frc);
        ytl.draw(g2, (int)(0), (int)(maxHeight/2));
        
        
        //average value line
        int averageLineX = (int)(d.width/10 + (maxWidth*((averagePropertyValue-minPropertyValue)/(maxPropertyValue-minPropertyValue))));
        Line2D averageLine = new Line2D.Double(
        		averageLineX,
        		0,
        		averageLineX,
        		maxHeight
        		);
        g2.draw(averageLine);
        //Average line label
        String averageLabel = "Avg. " + (double)((int)(averagePropertyValue*100))/100;
        TextLayout atl = new TextLayout(averageLabel, labels, frc);
        atl.draw(g2, averageLineX+2, 10);
    }
}
