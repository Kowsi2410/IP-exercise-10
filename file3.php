<!DOCTYPE html>
<html>
<head>
    <title>Address Book</title>
</head>
<body>
    <h1>Address Book</h1>

    <!-- Form for adding a new contact -->
    <h2>Add a New Contact</h2>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <input type="hidden" name="action" value="add">
        <input type="submit" value="Add Contact">
    </form>

    <!-- Form for updating an existing contact -->
    <h2>Update a Contact</h2>
    <form method="POST" action="">
        <label for="old_name">Name of the contact to update:</label>
        <input type="text" id="old_name" name="old_name" required><br>

        <h3>New Contact Information</h3>

        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name"><br>

        <label for="new_email">New Email:</label>
        <input type="email" id="new_email" name="new_email"><br>

        <label for="new_phone">New Phone Number:</label>
        <input type="tel" id="new_phone" name="new_phone"><br>

        <label for="new_address">New Address:</label>
        <input type="text" id="new_address" name="new_address"><br>

        <input type="hidden" name="action" value="update">
        <input type="submit" value="Update Contact">
    </form>

    <!-- Form for deleting a contact -->
    <h2>Delete a Contact</h2>
    <form method="POST" action="">
        <label for="delete_name">Name of the contact to delete:</label>
        <input type="text" id="delete_name" name="delete_name" required><br>

        <input type="hidden" name="action" value="delete">
        <input type="submit" value="Delete Contact">
    </form>

    <h2>All Contacts</h2>

    <?php
    // Contact class
    class Contact {
        private $name;
        private $email;
        private $phoneNumber;
        private $address;

        public function __construct($name, $email, $phoneNumber, $address) {
            $this->name = $name;
            $this->email = $email;
            $this->phoneNumber = $phoneNumber;
            $this->address = $address;
        }

        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function getPhoneNumber() {
            return $this->phoneNumber;
        }

        public function setPhoneNumber($phoneNumber) {
            $this->phoneNumber = $phoneNumber;
        }

        public function getAddress() {
            return $this->address;
        }

        public function setAddress($address) {
            $this->address = $address;
        }

        public function displayContact() {
            echo "Name: " . $this->name . "<br>";
            echo "Email: " . $this->email . "<br>";
            echo "Phone Number: " . $this->phoneNumber . "<br>";
            echo "Address: " . $this->address . "<br><br>";
        }
    }

    // AddressBook class
    class AddressBook {
        private $contacts = [];
        private $operationLogs = [];

        public function addContact($contact) {
            $this->contacts[] = $contact;
            $this->operationLogs[] = "Added contact: " . $contact->getName();
            echo "Contact added successfully!<br>";
        }

        public function updateContact($oldName, $newContact) {
            foreach ($this->contacts as &$contact) {
                if ($contact->getName() === $oldName) {
                    $contact->setName($newContact->getName());
                    $contact->setEmail($newContact->getEmail());
                    $contact->setPhoneNumber($newContact->getPhoneNumber());
                    $contact->setAddress($newContact->getAddress());
                    $this->operationLogs[] = "Updated contact: " . $oldName . " to " . $newContact->getName();
                    echo "Contact updated successfully!<br>";
                    return;
                }
            }
            echo "Contact not found!<br>";
        }

        public function deleteContact($name) {
            foreach ($this->contacts as $index => $contact) {
                if ($contact->getName() === $name) {
                    unset($this->contacts[$index]);
                    $this->operationLogs[] = "Deleted contact: " . $name;
                    echo "Contact deleted successfully!<br>";
                    return;
                }
            }
            echo "Contact not found!<br>";
        }

        public function displayAllContacts() {
            if (empty($this->contacts)) {
                echo "No contacts found!<br>";
                return;
            }

            foreach ($this->contacts as $contact) {
                $contact->displayContact();
            }
        }

        public function displayOperationLogs() {
            echo "<h2>Operation Logs:</h2>";
            if (empty($this->operationLogs)) {
                echo "No operations have been performed yet.<br>";
            } else {
                foreach ($this->operationLogs as $log) {
                    echo $log . "<br>";
                }
            }
        }
    }

    // Initialize an address book instance
    $addressBook = new AddressBook();

    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'];

        if ($action == 'add') {
            // Add a new contact
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $newContact = new Contact($name, $email,$phone, $address);
            $addressBook->addContact($newContact);

        } elseif ($action == 'update') {
            // Update an existing contact
            $oldName = $_POST['old_name'];
            $newName = $_POST['new_name'] ?? "";
            $newEmail = $_POST['new_email'] ?? "";
            $newPhone = $_POST['new_phone'] ?? "";
            $newAddress = $_POST['new_address'] ?? "";

            // Create a new contact with the updated information
            $newContact = new Contact($newName ?: $oldName, $newEmail, $newPhone, $newAddress);
            $addressBook->updateContact($oldName, $newContact);

        } elseif ($action == 'delete') {
            // Delete a contact
            $deleteName = $_POST['delete_name'];
            $addressBook->deleteContact($deleteName);
        }
    }

    // Display all contacts
    $addressBook->displayAllContacts();

    // Display operation logs
    $addressBook->displayOperationLogs();
    ?>

</body>
</html>