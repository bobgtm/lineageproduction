package main

import (
	"database/sql"
	"fmt"
	"log"
	"net/smtp"

	_ "github.com/go-sql-driver/mysql"
	"github.com/jordan-wright/email"
)

const (
	username          = "root"
	password          = ""
	hostname          = "localhost"
	port              = "3306"
	database          = "lineage"
	inventoryTable    = "inventory_syrup"
	productColumn     = "syrup_id"
	quantityColumn    = "quantity"
	storeColumn       = "store_id"
	notificationEmail = "bob.griff.29@gmail.com"
	smtpServer        = "smtp.gmail.com"
	smtpPort          = 587
	smtpUsername      = "robertgriffintm@gmail.com"
	smtpPassword      = "byuk gbfz gafd gqqe"
)

var notifiedProducts = make(map[int]bool)

func main() {
	dataSourceName := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s", username, password, hostname, port, database)

	db, err := sql.Open("mysql", dataSourceName)
	if err != nil {
		log.Fatalf("Error connecting to the database: %v", err)
	}
	defer db.Close()

	// Continuously monitor the inventory for changes
	for {
		err := monitorInventory(db)
		if err != nil {
			log.Printf("Error monitoring inventory: %v", err)
		}

		// Sleep for a while before checking for changes again

	}
}

func monitorInventory(db *sql.DB) error {
	// Query to monitor inventory for products with zero quantity
	query := fmt.Sprintf("SELECT it.syrup_id, it.store_id, st.name, p.product_name FROM inventory_syrup AS it LEFT OUTER JOIN products AS p on p.id=it.syrup_id LEFT OUTER JOIN shops AS st ON st.id=it.store_id WHERE quantity = %s", quantityColumn)

	rows, err := db.Query(query)
	if err != nil {
		return err
	}
	defer rows.Close()

	// Iterate through the rows to send notifications for zero quantity products
	for rows.Next() {
		var productID int
		var syrup_id string
		var store_id string
		var product_name string
		if err := rows.Scan(&productID, &syrup_id, &store_id, &product_name); err != nil {
			return err
		}

		if _, ok := notifiedProducts[productID]; !ok {
			// Send notification email for the product with zero quantity
			err := sendNotification(product_name, store_id)
			if err != nil {
				log.Printf("Error sending notification: %v", err)
			}

			// Mark the product as notified to avoid duplicate emails
			notifiedProducts[productID] = true
		}

	}

	return nil
}

func sendNotification(product_name string, store_id string) error {
	e := email.NewEmail()
	e.From = "Bobby <robertgriffintm@gmail.com>"
	e.To = []string{notificationEmail}
	e.Subject = "Product Inventory Alert"
	e.Text = []byte(fmt.Sprintf("%s has run out of %s.", store_id, product_name))

	auth := smtp.PlainAuth("", smtpUsername, smtpPassword, smtpServer)

	err := e.Send(fmt.Sprintf("%s:%d", smtpServer, smtpPort), auth)
	return err
}
