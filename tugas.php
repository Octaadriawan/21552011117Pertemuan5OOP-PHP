<?php

abstract class Media {
    protected $title;
    protected $isBorrowed;

    public function __construct($title) {
        $this->title = $title;
        $this->isBorrowed = false;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getIsBorrowed() {
        return $this->isBorrowed ? 'Dipinjam' : 'Tersedia';
    }

    abstract public function borrow();
    abstract public function returnMedia();
}


interface Borrowable {
    public function borrow();
    public function returnMedia();
}


trait BorrowableTrait {
    public function borrow() {
        if (!$this->isBorrowed) {
            $this->isBorrowed = true;
            echo "Media '{$this->title}' berhasil dipinjam.\n";
        } else {
            echo "Maaf, media '{$this->title}' sedang dipinjam.\n";
        }
    }

    public function returnMedia() {
        if ($this->isBorrowed) {
            $this->isBorrowed = false;
            echo "Media '{$this->title}' berhasil dikembalikan.\n";
        } else {
            echo "Maaf, media '{$this->title}' tidak sedang dipinjam.\n";
        }
    }
}


class Book extends Media implements Borrowable {
    use BorrowableTrait;

    private $author;
    private $year;

    public function __construct($title, $author, $year) {
        parent::__construct($title);
        $this->author = $author;
        $this->year = $year;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }

    public function printInfo() {
        echo "Buku '{$this->title}' (Penulis: {$this->author}, Tahun: {$this->year}, Status: {$this->getIsBorrowed()})\n";
    }
}


class Library {
    private $media = [];

    public function addMedia(Media $item) {
        $this->media[] = $item;
        echo "Media '{$item->getTitle()}' berhasil ditambahkan ke perpustakaan.\n";
    }

    public function printAvailableMedia() {
        echo "Daftar Media Tersedia:\n";
        foreach ($this->media as $item) {
            if (!$item->getIsBorrowed()) {
                echo "- ";
                $item->printInfo();
            }
        }
    }
}


$book1 = new Book("Harry Potter and the Sorcerer's Stone", "J.K. Rowling", 1997);
$book2 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 1925);

$library = new Library();
$library->addMedia($book1);
$library->addMedia($book2);

$book1->borrow();
$book2->borrow();

$library->printAvailableMedia();
?>
