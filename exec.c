#include <stdio.h>
#include <unistd.h>

int main()
{
	printf("exec - c\n");
	//execl("/bin/cat", "cat", "gg.txt", NULL);
	execl("./scp", "scp", "-i", "new.pem", "test.txt", "ec2-user@10.202.78.161:~", NULL);
	return 0;

}
