#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <sys/types.h>
#include <linux/inotify.h>

#define EVENT_SIZE  ( sizeof (struct inotify_event) )
#define EVENT_BUF_LEN     ( 1024 * ( EVENT_SIZE + 16 ) )

void go_copy(char * ip)
{
	char buf[255];
	sprintf(buf, "./scp -i new.pem ./java/* ec2-user@%s:~",ip);
	system(buf);
	printf("1\n");
}


int main( )
{
  int length, i = 0;
  int fd;
  int wd;
  char buffer[EVENT_BUF_LEN];

  fd = inotify_init();

  if ( fd < 0 ) {
    perror( "inotify_init" );
  }

  wd = inotify_add_watch( fd, "./", IN_CREATE | IN_DELETE );

  while(1){
  i=0;
  length = read( fd, buffer, EVENT_BUF_LEN ); 

  if ( length < 0 ) {
    perror( "read" );
  }  
  
  while ( i < length ) {     
      	struct inotify_event *event = ( struct inotify_event * ) &buffer[ i ];     
	if ( event->len ) {
      		if ( event->mask & IN_CREATE ) {
        		if ( event->mask & IN_ISDIR ) {}
        		else {
				if (strcmp(event->name,"new_ip.txt")==0){
					printf("file...%s\n", event->name);
					go_copy("10.202.78.161");
				}


			}
        }
      }
    i += EVENT_SIZE + event->len;
  }

  }
   
	inotify_rm_watch( fd, wd );
   	close( fd );

}
