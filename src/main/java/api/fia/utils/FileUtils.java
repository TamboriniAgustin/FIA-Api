package api.fia.utils;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

import org.springframework.web.multipart.MultipartFile;

public class FileUtils {
	public static void replaceFile(String path, MultipartFile newFile) throws IOException {
		File oldFile = new File(path);

        if(!oldFile.exists()) {
            oldFile.createNewFile();
        }
        
        try (InputStream inputStream = newFile.getInputStream()) {
            try (OutputStream outputStream = new FileOutputStream(oldFile)) {
                byte[] buffer = new byte[1024];
                int bytesRead;
                
                while ((bytesRead = inputStream.read(buffer)) != -1) {
                    outputStream.write(buffer, 0, bytesRead);
                }
            }
        }
    }
	
	public static void createDriverImagesDirectory(String path) throws IOException {
		File directory = new File(path);
		if(!directory.exists()) {
			directory.mkdirs();
        }
	}
}