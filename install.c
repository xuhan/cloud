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
	memset(buf, 0, 255);
	printf("%sd\n",ip);
	sprintf(buf, "/usr/bin/scp -o \"StrictHostKeyChecking no\" -i new.pem ./java/* ec2-user@%s:~",ip);
	printf("Trying: %s\n", buf);
	system(buf);
	
	memset(buf, 0, 255);
	sprintf(buf, "ssh -o \"StrictHostKeyChecking no\" -i new.pem ec2-user@%s 'java TCPServer &'",ip);
	printf("Trying: %s\n", buf);
	
	int pid = fork();
	if (pid == 0){
		system(buf);
	}

}


int main( )
{
  int length, i = 0;
  int fd;
  int wd;
  char buffer[EVENT_BUF_LEN];
FILE *in;
char s[255];
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
  sleep(1);
  if ( (in = fopen("new_ip.txt", "r")) == NULL) {
	printf("file error\n");  
  }
  memset(s,0,255);
  while (fgets(s, 255, in) != NULL) {
	s[strlen(s)-1]='\0';
	go_copy(s);
  }
  fcloseall(); 

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
