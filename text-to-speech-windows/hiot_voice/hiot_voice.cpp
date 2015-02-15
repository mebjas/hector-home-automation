#include <stdafx.h>
#include <sapi.h>
#include <iostream>
using namespace std;

wchar_t *convertCharArrayToLPCWSTR(const char* charArray)
{
    wchar_t* wString=new wchar_t[4096];
    MultiByteToWideChar(CP_ACP, 0, charArray, -1, wString, 4096);
    return wString;
}

int main(int argc, char* argv[])
{
	if (argc != 2) {
		cout<<1003;
		return -1;
	}
	cout<<"SPEAKING: "<<argv[1]<<endl;
	ISpVoice * pVoice = NULL;

    if (FAILED(::CoInitialize(NULL)))
        return FALSE;

    HRESULT hr = CoCreateInstance(CLSID_SpVoice, NULL, CLSCTX_ALL, IID_ISpVoice, (void **)&pVoice);
    if( SUCCEEDED( hr ) )
    {
		hr = pVoice->Speak(convertCharArrayToLPCWSTR(argv[1]), 0, NULL);
        pVoice->Release();
        pVoice = NULL;
    }

    ::CoUninitialize();

	getchar();
    return TRUE;
}