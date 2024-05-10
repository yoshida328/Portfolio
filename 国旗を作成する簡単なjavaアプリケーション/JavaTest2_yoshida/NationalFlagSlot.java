package JavaTest2_yoshida;

import java.awt.Color;
import java.awt.Font;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.SwingUtilities;

public class NationalFlagSlot extends JFrame {
    private Color[] colors = {Color.BLUE, Color.WHITE, Color.RED, Color.BLACK, Color.YELLOW, Color.GREEN};
    private JPanel[] panels;
    private JButton[] buttons;
    private JLabel countryLabel;

    public NationalFlagSlot() {
        setTitle("NationalFlagSlot");
        setSize(800, 400); // Increase the size of the window
        setDefaultCloseOperation(EXIT_ON_CLOSE);
        setLocationRelativeTo(null); // Center the window
        setLayout(new GridLayout(1, 3)); // Change GridLayout to 1 row, 3 columns

        panels = new JPanel[3];
        buttons = new JButton[3];
        countryLabel = new JLabel("France"); // Initialize country name label with default value
        countryLabel.setFont(new Font("Arial", Font.BOLD, 24)); // Increase font size

        for (int i = 0; i < 3; i++) {
            panels[i] = new JPanel();
            panels[i].setBackground(colors[i]);
            buttons[i] = new JButton("Change Color");

            buttons[i].addActionListener(new ButtonListener(i));

            panels[i].add(buttons[i]);
            add(panels[i]);
        }

        add(countryLabel); // Add country name label below panels

        setVisible(true);
    }

    private class ButtonListener implements ActionListener {
        private int index;

        public ButtonListener(int index) {
            this.index = index;
        }

        @Override
        public void actionPerformed(ActionEvent e) {
            panels[index].setBackground(colors[(int)(Math.random() * colors.length)]);
            checkCountry();
        }
    }

    private void checkCountry() {
        if (panels[0].getBackground().equals(Color.BLUE) && panels[1].getBackground().equals(Color.WHITE) && panels[2].getBackground().equals(Color.RED)) {
            countryLabel.setText("France");
        } else if (panels[0].getBackground().equals(Color.BLACK) && panels[1].getBackground().equals(Color.YELLOW) && panels[2].getBackground().equals(Color.RED)) {
            countryLabel.setText("Belgium");
        } else if (panels[0].getBackground().equals(Color.GREEN) && panels[1].getBackground().equals(Color.WHITE) && panels[2].getBackground().equals(Color.RED)) { // Check for Italy
            countryLabel.setText("Italy");
        } else if (panels[0].getBackground().equals(Color.RED) && panels[1].getBackground().equals(Color.YELLOW) && panels[2].getBackground().equals(Color.GREEN)) { // Check for Guinea
            countryLabel.setText("Guinea");
        } else if (panels[0].getBackground().equals(Color.BLUE) && panels[1].getBackground().equals(Color.YELLOW) && panels[2].getBackground().equals(Color.RED)) { // Check for Chad
            countryLabel.setText("Chad");
        } else if (panels[0].getBackground().equals(Color.GREEN) && panels[1].getBackground().equals(Color.WHITE) && panels[2].getBackground().equals(Color.GREEN)) { // Check for Nigeria
            countryLabel.setText("Nigeria");
        } else if (panels[0].getBackground().equals(Color.GREEN) && panels[1].getBackground().equals(Color.YELLOW) && panels[2].getBackground().equals(Color.RED)) { // Check for Mali
            countryLabel.setText("Mali");
        } else if (panels[0].getBackground().equals(Color.BLUE) && panels[1].getBackground().equals(Color.YELLOW) && panels[2].getBackground().equals(Color.RED)) { // Check for Romania
            countryLabel.setText("Romania");
        } else {
            countryLabel.setText("no country");
        }
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(NationalFlagSlot::new);
    }
}

