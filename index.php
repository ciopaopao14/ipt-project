<?php
  include('partials\header.php');
  include('partials\sidebar.php');
  include('database\database.php');

  $search_query = "";
  if (isset($_POST['query'])) {
    $search_query = $_POST['query'];
    $sql = "SELECT * FROM musics WHERE SONG_TITLE LIKE '%$search_query%' OR ARTIST LIKE '%$search_query%' OR GENRE LIKE '%$search_query%' ORDER BY ID DESC";
  } else {
    $sql = "SELECT * FROM musics ORDER BY ID DESC";
  }

  $musics = $conn->query($sql);

  if (!$musics) {
    die("Error in query: ". $conn->error);
  }

  $status = "";
  if (isset($_SESSION['status'])){
    $status = $_SESSION['status'];
    unset($_SESSION['status']);//remove the session
  }

  // Your PHP BACK CODE HERE

?>

  <main id="main" class="main">

  <?php if ($status == "created"):?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      New music has been added successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php elseif ($status == "error"):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Information updated
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php elseif ($status == "deleted"):?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      error occured
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif;?>

    <!-- ======= Page Title ======= -->
    <div class="pagetitle">
      <h1>MY MUSICS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="index.php">General</a></li>
          
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="card-title">Default Table</h5>
                </div>
                <div>
                  <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addMusicModal">Add music</button>
                </div>
              </div>

              <!-- Default Table -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Song title</th>
                    <th scope="col">Artist</th>
                    <th scope="col">Genre</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($musics->num_rows > 0):?>
                   <?php while($row = $musics->fetch_assoc()):?>
                    <tr>
                      <th scope="row"><?php echo $row["ID"];?></th>
                      <td><?php echo $row["SONG_TITLE"];?></td>
                      <td><?php echo $row["ARTIST"];?></td>
                      <td><?php echo $row["GENRE"];?></td>
                      <td>
                        <button class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['ID']; ?>">Edit</button>
                        <!--UPDATE-->
                        <div class="modal fade" id="editModal<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel<?php echo $row['ID']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <form action="database/update.php" method="POST">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="editLabel<?php echo $row['ID']; ?>">Music Information</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="container">
                                    <div class="row">
                                      <div class="col-12 mt-2">
                                       <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                                       
                                       <div class="col-12 mt-2">
                                        <label for="SONG_TITLE">TITLE</label>
                                        <input type="text" name="SONG_TITLE" id="SONG_TITLE" class="form-control" placeholder="Enter song title" value="<?php echo $row['SONG_TITLE']; ?>" required>
                                       </div>

                                       <div class="col-12 mt-2">
                                        <label for="ARTIST">ARTIST</label>
                                        <input type="text" name="ARTIST" id="ARTIST" class="form-control" placeholder="Enter artist name" value="<?php echo $row['ARTIST']; ?>" required>
                                       </div>

                                       <div class="col-12 mt-2">
                                        <label for="GENRE">GENRE</label>
                                        <input type="text" name="GENRE" id="GENRE" class="form-control" placeholder="Enter genre" value="<?php echo $row['GENRE']; ?>" required>
                                       </div>

                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <button class="btn btn-primary btn-sm mx-1" title="View Music Information" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['ID']; ?>">View</button>
                        <!--view-->
                        <div class="modal fade" id="viewModal<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewLabel<?php echo $row['ID']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <form action="database/create.php" method="POST">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="viewLabel<?php echo $row['ID']; ?>">Music Information</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="container">
                                    <div class="row">
                                      <div class="col-12 mt-2">
                                        <label for="SONG_TITLE">TITLE</label>
                                        <input type="text" name="SONG_TITLE" id="SONG_TITLE" class="form-control" placeholder="Enter song title" value="<?php echo $row['SONG_TITLE']; ?>" disabled>
                                      </div>
                                      <div class="col-12 mt-2">
                                        <label for="ARTIST">ARTIST</label>
                                        <input type="text" name="ARTIST" id="ARTIST" class="form-control" placeholder="Enter artist name" value="<?php echo $row['ARTIST']; ?>" disabled>
                                      </div>
                                      <div class="col-12 mt-2">
                                        <label for="GENRE">GENRE</label>
                                        <input type="text" name="GENRE" id="GENRE" class="form-control" placeholder="Enter genre" value="<?php echo $row['GENRE']; ?>" disabled>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['ID']; ?>">Delete</button>
                        <!--DELETE-->
                        <div class="modal fade" id="deleteModal<?php echo $row['ID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel<?php echo $row['ID']; ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <form action="database/delete.php" method="POST">
                              <div class="modal-content">
                                <div class="modal-body text-center">
                                  <h1 class="text-danger" style="font-size:50px"><strong>!</strong></h1>
                                  <h3>Are you sure you want to delete this music?</h3>
                                  <h4>This action cannot be undone</h4>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                  <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php endwhile;?>
                 <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">No record found</td>
                  </tr>
                  <?php endif;?>
                </tbody>
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>

        </div>

      </div>

      <!-- Modal -->
      <div class="modal fade" id="addMusicModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addMusicLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <form action="database/create.php" method="POST">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="addMusicLabel">Music Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="container">
                  <div class="row">
                    <div class="col-12 mt-2">
                      <label for="SONG_TITLE">TITLE</label>
                      <input type="text" name="SONG_TITLE" id="SONG_TITLE" class="form-control" placeholder="Enter song title" required>
                    </div>
                    <div class="col-12 mt-2">
                      <label for="ARTIST">ARTIST</label>
                      <input type="text" name="ARTIST" id="ARTIST" class="form-control" placeholder="Enter artist name" required>
                    </div>
                    <div class="col-12 mt-2">
                      <label for="GENRE">GENRE</label>
                      <input type="text" name="GENRE" id="GENRE" class="form-control" placeholder="Enter genre" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php
  include('partials\footer.php');
?>