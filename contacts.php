<?php

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
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
    
    public function getAddress() {
        return $this->address;
    }
    
    public function updateEmail($email) {
        $this->email = $email;
    }
    
    public function updatePhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }
    
    public function updateAddress($address) {
        $this->address = $address;
    }
}

class AddressBook {
    private $contacts = [];
    
    public function addContact(Contact $contact) {
        $this->contacts[] = $contact;
    }
    
    public function updateContactEmail($name, $email) {
        foreach ($this->contacts as $contact) {
            if ($contact->getName() === $name) {
                $contact->updateEmail($email);
                return true;
            }
        }
        return false; // Contact not found
    }
    
    public function updateContactPhoneNumber($name, $phoneNumber) {
        foreach ($this->contacts as $contact) {
            if ($contact->getName() === $name) {
                $contact->updatePhoneNumber($phoneNumber);
                return true;
            }
        }
        return false; // Contact not found
    }
    
    public function updateContactAddress($name, $address) {
        foreach ($this->contacts as $contact) {
            if ($contact->getName() === $name) {
                $contact->updateAddress($address);
                return true;
            }
        }
        return false; // Contact not found
    }
    
    public function deleteContact($name) {
        foreach ($this->contacts as $key => $contact) {
            if ($contact->getName() === $name) {
                unset($this->contacts[$key]);
                return true;
            }
        }
        return false; // Contact not found
    }
}

// Example usage:

$addressBook = new AddressBook();

// Add new contacts
$contact1 = new Contact("John Doe", "john@example.com", "123456789", "123 Main St");
$addressBook->addContact($contact1);

$contact2 = new Contact("Jane Smith", "jane@example.com", "987654321", "456 Elm St");
$addressBook->addContact($contact2);

// Update contact's email
$addressBook->updateContactEmail("John Doe", "john.doe@example.com");

// Update contact's phone number
$addressBook->updateContactPhoneNumber("Jane Smith", "555555555");

// Update contact's address
$addressBook->updateContactAddress("John Doe", "789 Oak St");

// Delete a contact
$addressBook->deleteContact("Jane Smith");

// Display contacts
foreach ($addressBook as $contact) {
    echo "Name: " . $contact->getName() . "\n";
    echo "Email: " . $contact->getEmail() . "\n";
    echo "Phone Number: " . $contact->getPhoneNumber() . "\n";
    echo "Address: " . $contact->getAddress() . "\n\n";
}
?>
